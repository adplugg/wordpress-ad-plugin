<?php

/**
 * AdPlugg Notice class.
 * The AdPlugg Notice class is used for working with adplugg notices.
 * @package AdPlugg
 * @since 1.2
 */
class AdPlugg_Notice {
    
    /* 
     * The notice_key is a key such as "nag_widget".
     * @var $notice_key string 
     */
    private $notice_key;
    
    /* 
     * The message that you want to display to the user.
     * @var $message string 
     */
    private $message;
    
    /* 
     * The notice type ('error', 'updated', or 'update-nag') See:
     * https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
     * @var $type string The type of notice this is.
     */
    private $type;
    
    /* 
     * Whether or not the message is dismissible.
     * @var $notice_key boolean
     */
    private $dismissible;
    
    /**
     * Constructor.
     */
    public function __construct() {
        //
    }
    
    /**
     * Static function to create a new Notice. Call using 
     * AdPlug_Notice::create('nag_widget', 'some message', true/false );
     * @param string $notice_key The notice_key is a key such as "nag_widget".
     * @param string $message The message that you want to display to the user.
     * @param boolean $dismissible Whether or not the message is dismissible.
     * @param string $type The notice type ('error', 'updated', or 'update-nag').
     * @return \self Works like a constructor.
     */
    public static function create(
                                $notice_key, 
                                $message, 
                                $type = 'updated', 
                                $dismissible = false) 
    {
        $instance = new self();
        
        $instance->notice_key = $notice_key;
        $instance->message = $message;
        $instance->type = $type;
        $instance->dismissible = $dismissible;
        
        return $instance;
    }
    
    /**
     * Static function to recreate a Notice. Call using 
     * AdPlug_Notice::recreate($data_array);
     * See the to_array function below for the expected array structure.
     * @param array $array An array containing the Notice data
     * @return \self Works like a constructor.
     */
    public static function recreate($array) {
        $instance = new self();
        
        $instance->notice_key = $array['notice_key'];
        $instance->message = $array['message'];
        $instance->type = $array['type'];
        $instance->dismissible = $array['dismissible'];
        
        return $instance;
    }
    
    /**
     * Gets the value of notice_key.
     * @return string Returns the notice_key.
     */
    public function get_notice_key() {
        return $this->notice_key;
    }
    
    /**
     * Gets the value of message.
     * @return string Returns the Notice message.
     */
    public function get_message() {
        return $this->message;
    }
    
    /**
     * Gets the value of type.
     * @return string Returns the Notice type.
     */
    public function get_type() {
        return $this->type;
    }
    
    /**
     * Gets the value of dismissible.
     * @return string Returns whether or not the Notice is dismissible.
     */
    public function is_dismissible() {
        return $this->dismissible;
    }
    
    /**
     * Converts the class into an array for inserting into a WordPress option.
     * @param array An array representation of the object.
     */
    public function to_array() {
        $data_array = array(
            'notice_key' => $this->notice_key,
            'message' => $this->message,
            'type' => $this->type,
            'dismissible' => $this->dismissible
        );
        
        return $data_array;
    }

}


