<?php

namespace App\View\Helper;

use Cake\Validation\Validation;

/**
 * Render table html
 * 
 * @package View.Helper
 * @created 2014-11-17
 * @updated 2015-04-09
 * @version 1.0.1
 * @author thailh
 * @copyright Oceanize INC
 */
class SimpleTableHelper extends AppHelper {

    /** @var array $helpers Use helpers */
    public $helpers = array('Form', 'Html', 'Common', 'Url');

    /**
     * Create input text/textarea/select/file    
     * @param array $item   
     * @param int $option (0: normail; 1: generate dynamic input base on data type)  
     * @return string Html
     */
    function input($item, $option = 0) {
        $attr = array();
        if (!isset($item['name'])) {
            $item['name'] = $item['id'];
        }
        $attr[] = "name=\"{$item['name']}\"";
        if (in_array($item['type'], array('text', 'checkbox'))) {
            $attr[] = "value=\"{$item['value']}\"";
            if ($item['type'] == 'checkbox' && $item['value'] == 1 && $option == 1) {
                $attr[] = "checked=\"checked\"";
            }
        }
        if (in_array($item['type'], array('image', 'video'))) {
            $attr[] = "type=\"file\"";
        } else {
            $attr[] = "type=\"{$item['type']}\"";
        }
        foreach ($item as $k => $v) {
            if (is_string($v) && in_array($k, array('id', 'name', 'value', 'class', 'style', 'width', 'height', 'rows', 'cols'))) {
                $attr[] = "{$k}=\"{$v}\"";
            }
        }
        $attr = implode(' ', $attr);
        if ($item['type'] == 'text') {
            return "<div class=\"td_input_text\"><input {$attr}/></div>";
        } elseif ($item['type'] == 'textarea') {
            return "<div class=\"td_textarea\"><textarea {$attr}>{$item['value']}</textarea></div>";
        } elseif ($item['type'] == 'checkbox') {
            return "<div class=\"td_input_checkbox\"><input {$attr} /></div>";
        } elseif ($item['type'] == 'image') {
            $html = "<div class=\"td_file\"><input {$attr} /></div>";
            if (!empty($item['value'])) {
                $html .= "<div class=\"td_img\"><img style=\"margin-top:5px;width:100px;\" src=\"{$this->Common->thumb($item['value'], '100x100')}\" /></div>";
            }
            return $html;
        } elseif ($item['type'] == 'select') {
            $select = "<div class=\"td_select\"><select {$attr}>";
            foreach ($item['options'] as $optionVal => $optionTxt) {
                $selected = '';
                if ($optionVal == $item['value']) {
                    $selected = "selected=\"selected\"";
                }
                $select .= "<option {$selected} value=\"{$optionVal}\">{$optionTxt}</option>";
            }
            return "{$select}</select></div>";
        }
        return '';
    }

    /**
     * Render table html    
     * @author thailh 
     * @param array $table Table information   
     * @return string Html
     */
    function render($table) {
        //$controller = $this->request->params['controller'];
        $modelName = $table['modelName'];
        $columns = $table['columns'];
        $dataset = $table['dataset'];
        $class = !empty($table['class']) ? $table['class'] : 'table table-hover'; // KienNH 2016/09/20
        $id = !empty($table['id']) ? $table['id'] : ''; // KienNH 2016/09/20
        if (empty($columns)) {
            return false;
        }
        $html = "<div class=\"form-body\">";
        $html .= $this->Form->create($modelName, array(
            'class' => 'form-table',
            'enctype' => 'multipart/form-data',
            'id' => 'dataForm',
        ));
        $html .= "<table id=\"{$id}\" class=\"{$class}\" cellspacing=\"0\" width=\"100%\">";
        foreach ($columns as $i => $item) {
            if (empty($item['id'])) {
                $columns[$i]['id'] = 'ID' . time() . rand(1000, 9999);
            }
            if (empty($item['type'])) {
                $columns[$i]['type'] = '';
            }
            if (empty($item['title'])) {
                $columns[$i]['title'] = '';
            }
            if (empty($item['value'])) {
                $columns[$i]['value'] = '';
            }
            if ($columns[$i]['type'] == 'link' && !isset($item['href'])) {
                $columns[$i]['href'] = '#';
            }
            if (empty($item['link'])) {
                $columns[$i]['link'] = '';
            }
            if (!empty($item['href'])) {
                //$columns[$i]['href'] = $this->Url->build($item['href']);
                $columns[$i]['href'] = $item['href'];
            }
        }

        $html .= '<thead>';
        $html .= '<tr>';
        $hidden = array();
        foreach ($columns as &$item) {
            $value = "";
            if ($item['type'] == 'hidden') {
                continue;
            }
            if ($item['type'] == 'checkbox' && empty($item['title'])) {
                $value .= "<th class=\"checkbox_{$item['id']}\"><input type=\"checkbox\" onclick=\"checkAll('{$item['name']}', this.checked ? 1 : 0)\" /></th>";
                $html .= $value;
                continue;
            }
            $options = array();
            $td_options = array();
            foreach ($item as $attrKey => $attrVal) {
                if ($attrKey == 'width') {
                    $options[] = "{$attrKey}=\"{$attrVal}\"";
                }
                if (in_array($attrKey, array('align'))) {
                    $td_options[] = "{$attrKey}=\"{$attrVal}\"";
                    unset($item[$attrKey]);
                }
                if ($this->Common->startsWith($attrKey, 'data-')) {// KienNH 2016/09/23 add 'data-'
                    $td_options[] = "{$attrKey}=\"{$attrVal}\"";
                }
            }
            $options = !empty($options) ? implode(' ', $options) : '';
            $item['td_options'] = !empty($td_options) ? implode(' ', $td_options) : '';
            $thTitle = $item['title'];
            if (isset($item['th_title'])) {
                $thTitle = $item['th_title'];
                unset($item['th_title']);
            }
            $iconSort = '';
            if (!empty($item['sort']) && !empty($item['title']) && !empty($item['id'])) {
                $requestParam = $this->request->query;
                $sortExplode = explode('-', !empty($requestParam['sort']) ? $requestParam['sort'] : '');
                if (!empty($sortExplode[1]) && $sortExplode[1] == 'DESC') {
                    $sort = "?sort={$item['id']}-ASC";
                    $iconSort = ($sortExplode[0] == $item['id']) ? "<i class='fa fa-fw fa-sort-desc'></i>" : '';
                } else {
                    $sort = "?sort={$item['id']}-DESC";
                    if (!empty($item['sort-default']) && ($sortExplode[0] == '')) {
                        $iconSort = "<i class='fa fa-fw fa-sort-asc'></i>";
                    } else {
                        $iconSort = ($sortExplode[0] == $item['id']) ? "<i class='fa fa-fw fa-sort-asc'></i>" : '';
                    }
                }
                $urlSort = $this->Html->url() . $sort;
                if (!empty($requestParam['date'])) {
                    $urlSort = $urlSort . "&date={$requestParam['date']}";
                }
                $value .= "<th {$options} {$item['td_options']}><a href='" . $urlSort . "' class='sort-col'>{$thTitle}{$iconSort}</a></th>";
            } else {
                $value .= "<th {$options} {$item['td_options']}>{$thTitle}</th>";
            }

            if (!empty($item['hidden'])) {
                $hidden[$item['id']] = true;
            } else {
                $html .= $value;
            }
        }
        $html .= '</tr>';
        $html .= '</thead>';

        unset($item);
        $rows = array();
        
        foreach ($dataset as $data) {
            $row = array();
            foreach ($columns as $item) {
                if (isset($item['empty']) && empty($data[$item['id']])) {
                    if ($item['type'] != 'checkbox' && empty($item['toggle'])) {
                        $data[$item['id']] = $item['empty'];
                    }
                }
                $search = $replace = array();
                foreach ($data as $fld => $val) {
                    if (is_array($val)) {
                        continue;
                    }
                    $search[] = '{' . $fld . '}';
                    $replace[] = $val;
                }
                if ($item['type'] == 'hidden') {
                    continue;
                }
                $options = array();
                foreach ($item as $attrKey => $attrVal) {
                    if (!in_array($attrKey, array(
                            'id',
                            'title',
                            'type',
                            'link',
                            'rules',
                            'options',
                            'td_options',
                            'hidden',
                            'before_image',
                            'after_image'
                        ))) {
                        $attrVal = str_replace($search, $replace, $attrVal);
                        if (is_scalar($attrVal)) {
                            if ($attrKey == 'src') {
                                $attrVal = $this->Common->thumb($attrVal, '60x60');
                            }
                            if (!empty($attrVal)) {
                                $options[] = "{$attrKey}=\"{$attrVal}\"";
                            }
                        }
                    }
                }
                if (!empty($item['class'])) {
                    $item['class'] = str_replace($search, $replace, $item['class']);
                }
                if (!empty($item['name'])) {
                    $item['name'] = str_replace($search, $replace, $item['name']);
                }
                if (!empty($item['value'])) {
                    $item['value'] = str_replace($search, $replace, $item['value']);
                }
                if (!empty($item['style'])) {
                    $item['style'] = str_replace($search, $replace, $item['style']);
                }
                // KienNH 2017-06-15 begin
                if (!empty($item['before_image'])) {
                    $item['before_image'] = str_replace($search, $replace, $item['before_image']);
                }
                if (!empty($item['after_image'])) {
                    $item['after_image'] = str_replace($search, $replace, $item['after_image']);
                }
                // KienNH end
                if (!empty($item['link_text'])) {
                    $item['link_text'] = str_replace($search, $replace, $item['link_text']);
                }
                if (!isset($data[$item['id']])) {
                    $data[$item['id']] = !empty($item['empty']) ? $item['empty'] : $item['title'];
                }
                if (!empty($item['rules']) && is_array($item['rules'])) {
                    // support for setting, generate dynamic inputs
                    $dynamicInput = false;
                    foreach ($item['rules'] as $ruleKey => $ruleValue) {
                        if (is_array($ruleValue)) {
                            $ruleValue['name'] = $item['name'];
                            $ruleValue['value'] = $data[$item['id']];
                            $item['rules'][$ruleKey] = $this->input($ruleValue, 1);
                            $dynamicInput = true;
                        } else if (!empty($ruleValue) && is_string($ruleValue)) {// KienNH, 216/01/19, fix bug userbeautyviewlogs
                            $item['rules'][$ruleKey] = str_replace($search, $replace, $ruleValue);
                        }
                    }
                    if ($dynamicInput == true) {
                        $data[$item['id']] = str_replace(
                            array_keys($item['rules']), array_values($item['rules']), $data[!empty($item['value']) ? $item['value'] : $item['id']]
                        );
                    } else {
                        if (!empty($item['value'])) {
                            $data[$item['id']] = $item['value'];
                        }
                        if (isset($item['rules'][$data[$item['id']]])) {
                            $data[$item['id']] = $item['rules'][$data[$item['id']]];
                        }
                    }
                }
                $value = $data[$item['id']];
                if (!empty($item['hidden_value'])) {
                    $value = '';
                }
                if ($item['type'] == 'url' && $value != '' && Validation::url($value)) {
                    $item['type'] = 'link';
                    $options['href'] = "href=\"{$value}\"";
                }
                $options = !empty($options) ? implode(' ', $options) : '';
                if ($item['type'] == 'link') {
                    if ($data[$item['id']] != '') {
                        $_link_text = $data[$item['id']];
                        if (!empty($item['link_text'])) {
                            $_link_text = $item['link_text'];
                        }
                        if (isset($item['button'])) {
                            $value = "<a {$options}><span class=\"label label-primary\">{$_link_text}</span></a>";
                        } else {
                            if(!empty($item['before_icon'])){
                                //LongDH 2017/07/13
                                $value = "<a {$options}>{$item['before_icon']} {$_link_text}</a>";
                            }else{
                                $value = "<a {$options}>{$_link_text}</a>";
                            }
                            
                        }
                    }
                }
                if (!empty($item['before'])) {
                    $value = "{$item['before']}: {$value}";
                }
                if (!empty($item['after'])) {
                    $value .= "{$item['after']}";
                }
                if ($item['type'] == 'image') {
                    // KienNH 2017-06-15 add before_image + after_image
                    $value = '';
                    if (!empty($item['before_image'])) {
                        $value .= $item['before_image'];
                    }
                    $value .= "<img {$options} />";
                    if (!empty($item['after_image'])) {
                        $value .= $item['after_image'];
                    }
                }
                if ($item['type'] == 'date') {
                    $value = self::getCommonComponent()->dateFormat($value);
                }
                if ($item['type'] == 'dateonly') {
                    $value = self::getCommonComponent()->dateFormat($value, true);
                }
                if ($item['type'] == 'dateFromString') {
                    $value = self::getCommonComponent()->dateFormatFromString($value);
                }
                if ($item['type'] == 'datetime') {
                    $value = self::getCommonComponent()->dateTimeFormat($value);
                }
                if ($item['type'] == 'number') {
                    $value = self::getCommonComponent()->nunmberFormat($value);
                }
                if ($item['type'] == 'time') {
                    $value = date('H:i', $value);
                }
                if ($item['type'] == 'currency') {
                    $value = self::getCommonComponent()->currencyFormat($value);
                }

                // KienNH 2016/06/16 begin
                if ($item['type'] == 'time_second') {
                    $value = gmdate("H:i", $value % 86400); // %86400 to fix 00:00
                }
                if (isset($item['nl2br']) && $item['nl2br']) {
                    $value = nl2br($value);
                }
                // KienNH end

                if (in_array($item['type'], array('text', 'checkbox', 'select', 'video'))) {
                    if ($item['type'] == 'checkbox' && !empty($item['toggle'])) {
                        $toggle_options = '';
                        if (!isset($data['id'])) {
                            $data['id'] = '0';
                        }
                        if (!isset($item['class'])) {
                            $item['class'] = "toggle-event";
                        }
                        if (!isset($item['toggle-onstyle'])) {
                            $item['toggle-onstyle'] = "primary";
                        }
                        if (isset($item['toggle-options'])) {
                            foreach ($item['toggle-options'] as $toggle_key => $toggle_val) {
                                $toggle_options .= " {$toggle_key} = \"$toggle_val\"";
                            }
                        }
                        $checked = $data[$item['id']];
                        $value = "<input value=\"{$data['id']}\" class=\"{$item['class']}\" {$checked} type=\"checkbox\" data-toggle=\"toggle\" data-onstyle=\"{$item['toggle-onstyle']}\" data-style=\"ios\" data-size=\"mini\" data-field=\"{$item['id']}\" {$toggle_options}>";
                    } else {
                        $value = $this->input($item);
                    }
                }
                if (!empty($item['limit']) && is_numeric($item['limit']) && mb_strlen($value) > $item['limit']) {
                    $value = mb_substr($value, 0, $item['limit']) . '...';
                }
                if ($item['type'] == 'has_media') {
                    if (isset($item['media_options'])) {
                        if (isset($item['media_options']['element'])) {
                            $element_data = array('key' => $item['id'], 'data' => $data);
                            $value = $this->_View->element($item['media_options']['element'], $element_data);
                        }
                    }
                }
                $icon_class = "";
                if ($item['type'] == 'icon') {
                    if (isset($item["icon_prefix"])) {
                        $icon_class .= $item["icon_prefix"];
                    }
                    if (isset($item["icon_valiations"])) {
                        $icon_class .= $item["icon_valiations"][$data[$item["id"]]];
                    } else {
                        $icon_class .= $data[$item['id']];
                    }
                    $value = "<i class=\"{$icon_class}\"></i> ";
                }
                $item['td_options'] = !empty($item['td_options']) ? str_replace($search, $replace, $item['td_options']) : ''; // KienNH 2016/09/23
                $row[$item['id']] = array(
                    'options' => !empty($item['td_options']) ? $item['td_options'] : '',
                    'value' => $value
                );
            }
            $rows[] = $row;
        }
        $html .= "<tbody>";
        foreach ($rows as $i => $row) {
            $html .= "<tr>";
            foreach ($row as $field => $rowItem) {
                if (!empty($hidden[$field])) {
                    continue;
                }
                $value = $rowItem['value'];
                // begin LongDH - format Price
                if(($field == 'price' || $field == 'total_price' || $field == 'total_tax') && is_numeric($rowItem['value'])){
                    $value = number_format($rowItem['value']);
                }
                if($field == 'content_type_popup'){
                    if(empty($rowItem['value'])){
                        $v = array(
                            'id' => $row['id']['value'],
                            'content_type' => $rowItem['value']
                        );
                        $value = $this->_View->element('popup',array('v'=>$v));
                    }
                }
                // end LongDH
                if (isset($table['merges'][$field])) {
                    foreach ($table['merges'][$field] as $merge) {
                        if (empty($row[$merge['field']]['value']))
                            continue;
                        //$value .= '<div class="mt5">';
                        $value .= '<div class="">';

                        if (is_string($merge)) {
                            $value .= $row[$merge];
                        } else {
                            if (!empty($merge['before'])) {
                                $value .= $merge['before'];
                            }
                            $value .= $row[$merge['field']]['value'];
                            if (!empty($merge['after'])) {
                                $value .= $merge['after'];
                            }

                            // KienNH 2016/06/10 begin
                            if (!empty($merge['after_ext_field']) && !empty($row[$merge['after_ext_field']]['value'])) {
                                if (!empty($merge['after_ext'])) {
                                    $value .= $merge['after_ext'];
                                }
                                $value .= $row[$merge['after_ext_field']]['value'];
                            }
                            // KienNH end
                        }
                        $value .= '</div>';
                    }
                }
                $html .= "<td {$rowItem['options']}>{$value}</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</tbody>";
        $html .= "</table>";

        unset($row);
        unset($rows);
        unset($hidden);
        if (!empty($table['buttons'])) {
            $html .= "<div class=\"form-group button-group\">";
            foreach ($table['buttons'] as $control) {
                if (empty($control['type']) || $control['type'] != 'submit') {
                    continue;
                }
                if (isset($control['type'])) {
                    unset($control['type']);
                }
                if (isset($control['button']) && $control['button']) {
                    $html .= $this->Form->button($control['value'], $control);
                } else {
                    $html .= $this->Form->submit($control['value'], $control);
                }
            }
            $html .= "</div>";
        }
        if (!empty($table['hiddens'])) {
            foreach ($table['hiddens'] as $control) {
                if (empty($control['name'])) {
                    $control['name'] = $control['id'];
                }
                if (empty($control['type'])) {
                    $control['type'] = 'hidden';
                }
                $html .= $this->Form->input($control['id'], $control);
            }
        }
        unset($table);
        $html .= $this->Form->input('action', array(
            'type' => 'hidden',
            'name' => 'action',
            'id' => 'action',
        ));
        $html .= $this->Form->input('action', array(
            'type' => 'hidden',
            'name' => 'actionId',
            'id' => 'actionId',
        ));
        $html .= $this->Form->end();
        $html .= "</div>";
        return $html;
    }

}
