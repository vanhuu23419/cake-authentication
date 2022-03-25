<?php
/**
 * Created by PhpStorm.
 * User: leminhtoan
 * Date: 11/13/14
 * Time: 19:39
 */

namespace App\Libs;
use App\Model\PLSQL\Common\EncryptFunction;
use Cake\I18n\FrozenTime;

class ValueUtil
{

    /**
     * Get value list from yml config file
     * @param $keys
     * @param array $options
     * @return array|null
     */
    public static function get($keys, $options = array()) {
        return ConfigUtil::getValueList($keys, $options);
    }

    /**
     * Get value list contain japanese and english
     * @param $keys
     * @param array $options
     * @return array|null
     */
    public static function getList($keys, $options = array()) {
        $options['getList'] = true;
        return ConfigUtil::getValueList($keys, $options);
    }

    /**
     * Convert from value into text in view
     *
     * @param $value property value Ex: 1
     * @param $listKey list defined in yml Ex: web.type
     * @return null|string text if exists else blank
     * @author sonPH
     */
    public static function valueToText($value, $listKey) {
        //Check params
        if(!isset($value) || !isset($listKey)){
            return NULL;
        }
        //Get list options
        $list = ValueUtil::get($listKey);
        if (empty($list)) {
            $list = ValueUtil::getList($listKey);
        }
        if(is_array($list) && isset($list[$value])){
            return h($list[$value]);
        }
        //Can't get value
        return NULL;
    }

    /**
     * Get value from const (in Yml config file)
     * @param $keys
     * @return int|null|string
     */
    public static function constToValue($keys) {
        return ConfigUtil::getValue($keys);
    }

    /**
     * Get text from const (in Yml config file)
     * @param $keys
     * @return int|null|string
     */
    public static function constToText($keys) {
        return ConfigUtil::getValue($keys, TRUE);
    }

    /**
     * Get value from test i
     * @param $searchText
     * @param $keys
     * @return int|null|string
     */
    public static function textToValue($searchText, $keys) {
        $valueList = ValueUtil::get($keys);
        foreach($valueList as $key => $text){
            if($searchText == $text){
                return $key;
            }
        }

        return NULL;
    }

} 