<?php

namespace SHC\Sensor;

//Imports
use SHC\Room\Room;
use RWF\Date\DateTime;

/**
 * Standard Sensor
 * 
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
abstract class AbstractSensor implements Sensor {

    /**
     * ID
     * 
     * @var String 
     */
    protected $id = 0;

    /**
     * Sensorpunkt ID
     *
     * @var Integer
     */
    protected $sensorPointId = 0;

    /**
     * Name
     * 
     * @var String 
     */
    protected $name = '';

    /**
     * Raeume
     * 
     * @var Array()
     */
    protected $rooms = array();

    /**
     * Sortierung
     * 
     * @var Array
     */
    protected $order = array();

    /**
     * Sichtbarkeit
     * 
     * @var Integer 
     */
    protected $visibility = 1;

    /**
     * Datenaufzeichnung
     * 
     * @var Boolean 
     */
    protected $dataRecording = false;

    /**
     * Zeit des aktuellsten Wertes
     * 
     * @var \RWF\Date\DateTime 
     */
    protected $time = null;
    
    /**
     * letzte 5 Werte
     * 
     * @var Array 
     */
    protected $oldValues = array(0 => array(), 1 => array(), 2 => array(), 3 => array(), 4 => array());
    
    /**
     * Sensorwerte geaendert
     * 
     * @var Boolean 
     */
    protected $isModified = false;

    /**
     * setzt die Sensor ID
     * 
     * @param  String $id Sensor ID
     * @return \SHC\Sensor\Sensor
     */
    public function setId($id) {

        $this->id = $id;
        return $this;
    }

    /**
     * gibt die Sensor ID zurueck
     * 
     * @return String
     */
    public function getId() {

        return $this->id;
    }

    /**
     * setzt die Sensor Punkt ID
     *
     * @param  String $id Sensor Punkt ID
     * @return \SHC\Sensor\Sensor
     */
    public function setSensorPointId($id) {

        $this->sensorPointId = $id;
        return $this;
    }

    /**
     * gibt die Sensor Punkt ID zurueck
     *
     * @return String
     */
    public function getSensorPointId() {

        return $this->sensorPointId;
    }

    /**
     * setzt den Namen des Sensors
     * 
     * @param  String $name Name des Sensors
     * @return \SHC\Sensor\Sensor
     */
    public function setName($name) {

        $this->name = $name;
        return $this;
    }

    /**
     * gibt den Namen des Sensors zurueck
     * 
     * @return String
     */
    public function getName() {

        return ($this->name != '' ? $this->name : 'Sensor-ID-'. $this->id);
    }

    /**
     * fuegt einen Raum hinzu
     *
     * @param  Integer $roomId Raum ID
     * @return \SHC\Sensor\Sensor
     */
    public function addRoom($roomId) {

        $this->rooms[] = $roomId;
        return $this;
    }

    /**
     * setzt eine Liste mit Raeumen
     *
     * @param  Array $roomId Raum IDs
     * @return \SHC\Sensor\Sensor
     */
    public function setRooms(array $rooms) {

        $this->rooms = $rooms;
        return $this;
    }

    /**
     * entfernt einen Raum
     *
     * @param  Integer $roomId Raum ID
     * @return \SHC\Sensor\Sensor
     */
    public function removeRoom($roomId) {

        $this->rooms = array_diff($this->rooms, array($roomId));
        return $this;
    }

    /**
     * prueft on das Element dem Raum mit der uebergebenen ID zugeordnet ist
     *
     * @param  Integer $roomId Raum ID
     * @return Boolean
     */
    public function isInRoom($roomId) {

        return in_array($roomId, $this->rooms);
    }

    /**
     * gibt eine Liste mit allen Raeumen zurueck
     *
     * @return Array
     */
    public function getRooms() {

        return $this->rooms;
    }

    /**
     * setzt die Sortierung
     *
     * @param  Array $order Sortierung
     * @return \SHC\Sensor\Sensor
     */
    public function setOrder(array $order) {

        $this->order = $order;
        return $this;
    }

    /**
     * setzt die Sortierungs ID
     *
     * @param  Integer $roomId  Raum ID
     * @param  Integer $orderId Sortierungs ID
     * @return \SHC\Sensor\Sensor
     */
    public function setOrderId($roomId, $orderId) {

        $this->order[$roomId] = $orderId;
        return $this;
    }

    /**
     * gibt die Sortierungs ID zurueck
     *
     * @param  Integer $roomId  Raum ID
     * @return Integer
     */
    public function getOrderId($roomId) {

        if(isset($this->order[$roomId])) {

            return $this->order[$roomId];
        }
        return 0;
    }

    /**
     * setzt die Sichtbarkeit
     * 
     * @param  Boolean $visible
     * @return \SHC\Sensor\Sensor
     */
    public function visibility($visible) {

        if ($visible == true) {

            $this->visibility = true;
        } else {

            $this->visibility = false;
        }
        return $this;
    }

    /**
     * gibt die Sichtbarkeit des Sensors zurueck
     * 
     * @return Integer
     */
    public function isVisible() {

        return $this->visibility;
    }

    /**
     * aktiviert/deaktiviert das aufzeichnen der Sensordaten
     * 
     * @param  Boolean $enabled aktiviert/deaktiviert
     * @return \SHC\Sensor\Sensor
     */
    public function enableDataRecording($enabled) {

        $this->dataRecording = $enabled;
        return $this;
    }

    /**
     * gibt an ob die Daten des Sensors aufgezeichnet werden sollen
     * 
     * @return Boolean
     */
    public function isDataRecordingEnabled() {

        return $this->dataRecording;
    }

    /**
     * setzt die Zeit der letzten Verbindung
     * 
     * @param  DateTime $time
     * @return \SHC\Sensor\AbstractSensor
     */
    public function setTime(DateTime $time) {
        
        $this->time = $time;
        return $this;
    }
    
    /**
     * gibt den Zeitstempel des letzten Sensorwertes zurueck
     * 
     * @return \RWF\Date\DateTime
     */
    public function getTime() {

        return $this->time;
    }
    
    /**
     * gibt die letzten 5 Sensorwerte zurueck
     * 
     * @return Array
     */
    public function getOldValues() {
        
        return $this->oldValues;
    }
    
    /**
     * gibt an ob die Sensorwerte vereandert wurden
     * 
     * @return Boolean
     */
    public function isModified() {
        
        return $this->isModified;
    }

}