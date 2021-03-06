<?php

namespace Weeks\CurrencyWatcher\Application\Controller;

use Psr\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Weeks\CurrencyWatcher\Application\Repository\DoctrineCurrencyRepository;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Manager\CurrencyManager;
use Weeks\CurrencyWatcher\Domain\Manager\RateManager;
use Weeks\CurrencyWatcher\Domain\Transformer\ChartJsRateTransformer;

class SiteController extends BaseController
{
    /**
     * @var DoctrineCurrencyRepository
     */
    protected $currencyRepository;

    public function current(Request $request, Response $response, $base, $target)
    {
        $currencyManager = $this->container->get(CurrencyManager::class);

        $base = $currencyManager->getByCode($base);
        $target = $currencyManager->getByCode($target);

        $rateManager = $this->container->get(RateManager::class);

        $rate = $rateManager->fetchNewRate(
            $base,
            $target
        );

        return $this->getTwig()->render(
            $response,
            'current.html.twig',
            compact('base', 'target', 'rate')
        );
    }

    public function history(Request $request, Response $response, $base, $target)
    {
        try {
            $currencyManager = $this->container->get(CurrencyManager::class);
            $baseCurrency = $currencyManager->getByCode($base);

            if (!$baseCurrency instanceof Currency) {
                throw new \Exception(sprintf(
                    '%s is not an accepted currency code.',
                    $base
                ));
            }

            $targetCurrency = $currencyManager->getByCode($target);

            if (!$targetCurrency instanceof Currency) {
                throw new \Exception(sprintf(
                    '%s is not an accepted currency code.',
                    $target
                ));
            }

            $rateManager = $this->container->get(RateManager::class);
            $limit = 50;

            if (isset($request->getQueryParams()['limit'])) {
                $limit = $request->getQueryParams()['limit'];
            }

            $rates = $rateManager->getHistoricalRates($baseCurrency, $targetCurrency, $limit);

            $chartData = $this->getChartData($rates, $baseCurrency, $targetCurrency);

            $high = $rateManager->getHighestRate($baseCurrency, $targetCurrency);

            $low = $rateManager->getLowRate($baseCurrency, $targetCurrency);
        } catch (\Exception $e) {
            $response->getBody()->write($e->getMessage());

            return $response;
        }

        return $this->getTwig()->render($response, 'history.html.twig', [
            'base'      => $baseCurrency,
            'target'    => $targetCurrency,
            'chartData' => $chartData,
            'high'      => $high,
            'low'       => $low,
        ]);
    }

    /**
     * @param Rate[]   $rates
     *
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return array
     */
    private function getChartData($rates, Currency $baseCurrency, Currency $targetCurrency)
    {
        $transformer = new ChartJsRateTransformer();

        return $transformer->setLabel(
            sprintf(
                '%s to %s',
                $baseCurrency->getCode(),
                $targetCurrency->getCode()
            )
        )->setData($rates)
            ->transform();
    }
}