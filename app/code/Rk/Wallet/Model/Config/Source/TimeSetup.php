<?php
namespace Rk\Wallet\Model\Config\Source;

class TimeSetup extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    protected $_optionsData;

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => 'one', 'label' => __('one')],
                ['value' => 'two', 'label' => __('two')]

                
            ];
        }
        return $this->_options;
    }
    final public function toOptionArray()
    {
         return array(
            array('value' => 'one', 'label' => __('one')),
            array('value' => 'two', 'label' => __('two'))
        
         );
     }
}
