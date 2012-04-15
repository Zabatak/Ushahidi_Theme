<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Zabatak Hook
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Zabatak Team <abbas@zabatak.com> 
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
class zabatak_cars_block {

    public function __construct() {


        $block = array(
            "classname" => "zabatak_cars_block",
            "name" => "Car-theft Campaing",
            "description" => "Car-theft Campaing."
        );

        blocks::register($block);
    }

    public function block() {
        $content = new View('blocks/main_cars');



        $this->db = new Database();

        $content->total_stolen = $this->db->query('SELECT * FROM incident, incident_category ic WHERE incident.id = ic.incident_id and incident_active = 1 and ic.category_id = 22')->count();
        $content->total_founds = $this->db->query('SELECT * FROM incident, incident_category ic WHERE incident.id = ic.incident_id and incident_active = 1 and ic.category_id = 35')->count();
        $content->total_returned = 11;

        echo $content;
    }

}

new zabatak_cars_block;



