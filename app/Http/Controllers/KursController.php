<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Kurs;

class KursController extends Controller
{
    public function crawl()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://www.smartdeal.co.id/rates/dki_banten');
        $htmlContent = $response->getContent();

        $crawler = new Crawler($htmlContent);

        Kurs::truncate();
        $data = [];
        // dd($crawler->filter('#tableExchange tr.body')->html());
        $crawler->filter('#tableExchange tr.body')->each(function ($node) use (&$data) {
            $columns = $node->filter('td')->each(function ($col) {
                return trim($col->text());
            });

            if (count($columns) >= 4) {
                $data[] = [
                    'currency'      => $columns[0] ?? '',
                    'denomination'  => $columns[1] ?? '',
                    'buying_rate'   => isset($columns[2]) ? floatval(str_replace(',', '', $columns[2])) : 0,
                    'selling_rate'  => isset($columns[3]) ? floatval(str_replace(',', '', $columns[3])) : 0
                ];
            }
        });

        foreach ($data as $rate) {
            Kurs::updateOrCreate(
                ['currency' => $rate['currency'], 'denomination' => $rate['denomination']],
                $rate
            );
        }

        return response()->json($data);
    }
}
