<?php

namespace SHC\Sensor\vSensors;

//Imports
use RWF\Util\String;
use SHC\Sensor\AbstractSensor;

/**
 * Vitueller Temperatur Sensor
 *
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2015, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
class Temperature extends AbstractSensor {

    /**
     * Liste der Sensoren
     *
     * @var array
     */
    protected $sensors = array();

    /**
     * Minimalwert
     *
     * @var float
     */
    protected $min = 0.0;

    /**
     * Mittelwert
     *
     * @var float
     */
    protected $average = 0.0;

    /**
     * Maximalwert
     *
     * @var float
     */
    protected $max = 0.0;

    /**
     * @param array $sensors Sensoren
     */
    public function __construct(array $sensors = array()) {

        foreach($sensors as $sensor) {

            $this->addSensor($sensor);
        }
        $this->processData();
    }

    /**
     * fuegt einen Temperatursensor hinzu
     *
     * @param \SHC\Sensor\Model\Temperature $sensor
     */
    public function addSensor(\SHC\Sensor\Model\Temperature $sensor) {

        $this->sensors[] = $sensor;
    }

    /**
     * verarbeitet die Daten der einzelnen Sensoren
     */
    public function processData() {

        $this->min = null;
        $this->average = null;
        $this->max = null;
        $sum = 0.0;
        $count = 0;
        foreach($this->sensors as $sensor) {

            /* @var $sensor \SHC\Sensor\Model\Temperature */
            $val = $sensor->getTemperature();

            //Minimalwert
            if($val < $this->min || $this->min === null) {

                $this->min = $val;
            }

            //Mittelwert
            $sum += $val;
            $count++;

            //Maximalwert
            if($val > $this->max || $this->max === null) {

                $this->max = $val;
            }
        }

        //Mittelwert auswerten
        $this->average = ($sum / $count);
    }

    /**
     * gibt die Minimale Temperatur zurück
     *
     * @return float
     */
    public function getMinTemperature() {

        return $this->min;
    }

    /**
     * gibt die Minimale Temperatur zur Anzeige zurück
     *
     * @return string
     */
    public function getMinDisplayTemperature() {

        return String::formatFloat($this->getMinTemperature(), 1) .' °C';
    }

    /**
     * gibt die Mittlere Temperatur zurück
     *
     * @return float
     */
    public function getAvarageTemperature() {

        return $this->average;
    }

    /**
     * gibt die Mittlere Temperatur zur Anzeige zurück
     *
     * @return string
     */
    public function getAvarageDisplayTemperature() {

        return String::formatFloat($this->getAvarageTemperature(), 1) .' °C';
    }

    /**
     * gibt die Maximale Temperatur zurück
     *
     * @return float
     */
    public function getMaxTemperature() {

        return $this->max;
    }

    /**
     * gibt die Maximale Temperatur zur Anzeige zurück
     *
     * @return string
     */
    public function getMaxDisplayTemperature() {

        return String::formatFloat($this->getMaxTemperature(), 1) .' °C';
    }
}