<?php

namespace frontend\controllers;

use Yii;

class OngkirController extends \yii\web\Controller
{
    public $base_url = 'http://api.rajaongkir.com';
    public $key = '6d042ce728b1fa32275afbb1d9ab87ba';
    public function getData($url)
    {

        $curl = curl_init($url);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base_url . "/api/" . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key:$this->key",
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function actionProvince($id = null)
    {
        $province = $this->getData('province');
        if (!empty($id)) {
            $province = $this->getData('province?id=' . $id);
        }
        $status = json_decode($province)->rajaongkir->status;
        $data = json_decode($province)->rajaongkir->results;
        if ($status->code == '200') {

            $send = json_encode($data);
        } else {
            $send = json_encode('error');
        }
        return $send;
    }

    public function actionCity($province = null, $id = null)
    {
        if (!empty($province) && !empty($id)) {

            $province = $this->getData('city?province=' . $province . '&id=' . $id);
        } else if (!empty($province)) {
            $province = $this->getData('city?province=' . $province);
        } else if (!empty($id)) {

            $province = $this->getData('city?id=' . $id);
        } else {
            $province = $this->getData('city');
        }

        $status = json_decode($province)->rajaongkir->status;
        $data = json_decode($province)->rajaongkir->results;
        if ($status->code == '200') {

            $send = json_encode($data);
        } else {
            $send = json_encode('Error Connection');
        }
        return $send;
    }

    public function actionSub($city = null)
    {
        $province = $this->getData('subdistrict');
        if (!empty($city)) {
            $province = $this->getData('subdistrict?city=' . $city);
        }
        $status = json_decode($province)->rajaongkir->status;
        $data = json_decode($province)->rajaongkir->results;
        if ($status->code == '200') {

            $send = json_encode($data);
        } else {
            $send = json_encode('error');
        }
        return $send;
    }

    public function actionCost($destination, $weight, $courier, $sub = false)
    {
        $curl = curl_init();
        $origin = Yii::$app->params['origin_ongkir'];
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base_url . "/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => ($sub) ? "origin=$origin&originType=city&destination=$destination&destinationType=subdistrict&weight=$weight&courier=$courier" : "origin=$origin&destination=$destination&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key:$this->key",
            ),
        ));

        $response = curl_exec($curl);

        $parse = json_decode($response, true);
        if (isset($parse)) {

            $data = $parse['rajaongkir'];
            if ($data['status']['code'] == '200') {

                $items = array();
                foreach ($data['results'][0]['costs'] as $value) {
                    $items[] = [
                        'id' => $value['cost'][0]['value'] . '#' . $value['service'] . ' - ' . $value['description'] . ' (' . $value['cost'][0]['etd'] . ' )',
                        'text' => $value['description'] . ' - ' . number_format($value['cost'][0]['value']) . ' ( ' . $value['cost'][0]['etd'] . ' )',
                    ];
                }
            } else {

                $items[] = [
                    'id' => null,
                    'text' => $data['status']['code'] . ' - ' . $data['status']['description'],
                ];
            }
        } else {

            $items[] = [
                'id' => null,
                'text' => 'Connection Time Out !',
            ];
        }

        curl_close($curl);

        return json_encode($items);
    }

}
