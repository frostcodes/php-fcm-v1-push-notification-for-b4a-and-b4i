<?php
/**
 * FCM Data wrapper
 * 
 * @author Frost Codes ( Oluwaseyi Aderinkomi )
 * @link https://seyi.punchlinetech.com
 * @link https://punchlinetech.com
 */

namespace phpFCMv1;

class Data extends Base {

    public function setCustomData(array $data, array $customMessageFields = array()) {
        $this->validateCurrent($data);
        $this->validateCurrent($customMessageFields);
        $this->setPayload(
         array_merge(array('data' => $data), $customMessageFields)
        );
    }

    /**
     * @return array
     * @throws \UnderflowException
     */
    public function __invoke() {
        return parent ::__invoke();
    }
}