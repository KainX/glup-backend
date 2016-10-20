    
<?php
    /**
    Aes encryption
    */
    class AES {

      protected $key = '4d1$hk3yka1z3n:)';
      protected $cipher = MCRYPT_RIJNDAEL_128;
      //protected $data;
      protected $mode = MCRYPT_MODE_ECB;
      protected $IV;

    /**
    * 
    * @param type $data
    * @param type $blockSize
    * @param type $mode
    */
      function __construct(){//$data = null) {
        //$this->data = $data;
        $this->setIV("");
      }
            
    /**
    * 
    * @return boolean
    */
      public function validateParams() {
        if ($this->key != null &&
            $this->cipher != null) {
          return true;
        } else {
          return FALSE;
        }
      }
      
      public function setIV($IV) {
            $this->IV = $IV;
        }

      protected function getIV() {
          if ($this->IV == "") {
            $this->IV = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), MCRYPT_RAND);
          }
          return $this->IV;
      }
      
    /**
    * @return type
    * @throws Exception
    */
      public function encrypt($data) {
        
        if ($this->validateParams()) {
          return trim(base64_encode(
            mcrypt_encrypt(
              $this->cipher, $this->key, $data, $this->mode, $this->getIV())));
        } else {
          throw new Exception('Invlid params!');
        }
        $this->setIV("");
      }

    /**
    * 
    * @return type
    * @throws Exception
    */
      public function decrypt($data) {
        if ($this->validateParams()) {
          return trim(mcrypt_decrypt(
            $this->cipher, $this->key, base64_decode($data), $this->mode, $this->getIV()));
        } else {
          throw new Exception('Invlid params!');
        }
        $this->setIV("");
      }
      
    }