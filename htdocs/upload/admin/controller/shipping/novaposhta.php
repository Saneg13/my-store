<?php

/**
 * OpenCart Ukrainian Community
 * Made in Ukraine
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 *
 * @category   OpenCart
 * @package    OCU Nova Poshta
 * @copyright  Copyright (c) 2011 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 * @version    $Id: catalog/model/shipping/ocu_ukrposhta.php 1.2 2014-12-27 19:18:40
 */
/**
 * @category   OpenCart
 * @package    OCU OCU Nova Poshta
 * @copyright  Copyright (c) 2011 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 */

class ControllerShippingNovaPoshta extends Controller {

    private $error = array();


    public function index() {

        $this->load->language('shipping/novaposhta');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('novaposhta', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['token'] = $this->session->data['token'];

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_select'] = $this->language->get('text_select');

        $this->data['entry_cost'] = $this->language->get('entry_cost');
        $this->data['entry_sender_warehouse'] = $this->language->get('entry_sender_warehouse');
        $this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_api_key'] = $this->language->get('entry_api_key');
        $this->data['entry_sender_city'] = $this->language->get('entry_sender_city');
        $this->data['entry_comment'] = $this->language->get('entry_comment');
        $this->data['entry_send_order_status'] = $this->language->get('entry_send_order_status');
        $this->data['entry_sender_organization'] = $this->language->get('entry_sender_organization');
        $this->data['entry_sender_person'] = $this->language->get('entry_sender_person');
        $this->data['entry_sender_phone'] = $this->language->get('entry_sender_phone');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_shipping'),
            'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('shipping/novaposhta', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('shipping/novaposhta', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['novaposhta_api_key'])) {
            $this->data['novaposhta_api_key'] = $this->request->post['novaposhta_api_key'];
        } else {
            $this->data['novaposhta_api_key'] = $this->config->get('novaposhta_api_key');
        }

        if (isset($this->request->post['novaposhta_sender_organization'])) {
            $this->data['novaposhta_sender_organization'] = $this->request->post['novaposhta_sender_organization'];
        } else {
            $this->data['novaposhta_sender_organization'] = $this->config->get('novaposhta_sender_organization');
        }

        if (isset($this->request->post['novaposhta_sender_person'])) {
            $this->data['novaposhta_sender_person'] = $this->request->post['novaposhta_sender_person'];
        } else {
            $this->data['novaposhta_sender_person'] = $this->config->get('novaposhta_sender_person');
        }

        if (isset($this->request->post['novaposhta_sender_phone'])) {
            $this->data['novaposhta_sender_phone'] = $this->request->post['novaposhta_sender_phone'];
        } else {
            $this->data['novaposhta_sender_phone'] = $this->config->get('novaposhta_sender_phone');
        }

        if (isset($this->request->post['novaposhta_geo_zone_id'])) {
            $this->data['novaposhta_geo_zone_id'] = $this->request->post['novaposhta_geo_zone_id'];
        } else {
            $this->data['novaposhta_geo_zone_id'] = $this->config->get('novaposhta_geo_zone_id');
        }

        if (isset($this->request->post['novaposhta_comment'])) {
            $this->data['novaposhta_comment'] = $this->request->post['novaposhta_comment'];
        } else {
            $this->data['novaposhta_comment'] = $this->config->get('novaposhta_comment');
        }


        if (isset($this->request->post['novaposhta_sender_city'])) {
            $this->data['novaposhta_sender_city'] = $this->request->post['novaposhta_sender_city'];
        } else {
            $this->data['novaposhta_sender_city'] = $this->config->get('novaposhta_sender_city');
        }

        if (isset($this->request->post['novaposhta_status'])) {
            $this->data['novaposhta_status'] = $this->request->post['novaposhta_status'];
        } else {
            $this->data['novaposhta_status'] = $this->config->get('novaposhta_status');
        }

        if (isset($this->request->post['novaposhta_sort_order'])) {
            $this->data['novaposhta_sort_order'] = $this->request->post['novaposhta_sort_order'];
        } else {
            $this->data['novaposhta_sort_order'] = $this->config->get('novaposhta_sort_order');
        }

        $this->load->model('localisation/order_status');
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['novaposhta_send_order_status'])) {
            $this->data['novaposhta_send_order_status'] = $this->request->post['novaposhta_send_order_status'];
        } else {
            $this->data['novaposhta_send_order_status'] = $this->config->get('novaposhta_send_order_status');
        }

        $this->load->model('localisation/geo_zone');

        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/zone');

        $this->data['zones'] = $this->model_localisation_zone->getZones();
        $this->load->model('localisation/language');
        $this->data['languages'] = $this->model_localisation_language->getLanguages();


        if (isset($this->request->post['novaposhta_sender_warehouse'])) {
            $this->data['novaposhta_sender_warehouse'] = $this->request->post['novaposhta_sender_warehouse'];
        } else {
            $this->data['novaposhta_sender_warehouse'] = $this->config->get('novaposhta_sender_warehouse');
        }


        $this->template = 'shipping/novaposhta.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }


    public function getCities() {
        $json = array();

            if ($this->config->get('novaposhta_api_key')) {

                $xml  = '<?xml version="1.0" encoding="utf-8" ?>';
                $xml .= '<file>';
                    $xml .= '<auth>' . $this->config->get('novaposhta_api_key') . '</auth>';
                    $xml .= '<city/>';
                $xml .= '</file>';


                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'http://orders.novaposhta.ua/xml.php');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec($ch);
                curl_close($ch);

                $city_names = array();
                if ($response) {
                    $xml = simplexml_load_string($response);
                    foreach ($xml->result->cities->city as $city) {
                        if ($this->language->get('code') == 'ru') {
                            $city_names[] = $city->nameRu;
                        } else {
                            $city_names[] = $city->nameUkr;
                        }
                    }
                }
                $results = array_unique($city_names);

                if ($results) {
                    foreach ($results as $result) {
                        $json[] = array(
                          'city' => (string) $result
                        );
                    }
                }
            }


        $this->response->setOutput(json_encode($json));
    }


    public function getWarehouses() {
        $json = array();

        if (isset($this->request->get['filter']) && $this->config->get('novaposhta_api_key')) {

            $xml  = '<?xml version="1.0" encoding="utf-8" ?>';
            $xml .= '<file>';
                $xml .= '<auth>' . $this->config->get('novaposhta_api_key') . '</auth>';
                $xml .= '<warenhouse/>';
                $xml .= '<filter>' . $this->request->get['filter'] . '</filter>';
            $xml .= '</file>';


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'http://orders.novaposhta.ua/xml.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $xml = simplexml_load_string($response);

                foreach ($xml->result->whs->warenhouse as $warehouse) {
                    if ($this->language->get('code') == 'ru') {
                        $json[] = array(
                          'warehouse' => (string) str_replace(array('"', "'"), '', $warehouse->addressRu),
                          'number' => (string) str_replace(array('"', "'"), '', $warehouse->number),
                        );
                    } else {
                        $json[] = array(
                          'warehouse' => (string) str_replace(array('"', "'"), '', $warehouse->address),
                          'number' => (string) str_replace(array('"', "'"), '', $warehouse->number),
                        );
                    }
                }
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'shipping/novaposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
