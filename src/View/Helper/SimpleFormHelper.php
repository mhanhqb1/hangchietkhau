<?php

namespace App\View\Helper;

/**
 * 
 * Render form html
 * @package View.Helper
 * @created 2014-11-29
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class SimpleFormHelper extends AppHelper {

    /** @var array $helpers Use helpers */
    public $helpers = array('Form', 'Html', 'Common');

    /**
     * Render form html
     *     
     * @author thailvn
     * @param array $form Form information    
     * @return string Form html 
     */
    public function render($form = null) {
        if (empty($form)) {
            return false;
        }
        $html = "<div class=\"form-body\">";
        $form['attributes']['novalidate'] = true;
        $this->Form->templates($form['templates']);
        $html .= $this->Form->create($form['model'], $form['attributes']);
        $btnCount = 0;
        foreach ($form['elements'] as $control) {
            if (!isset($control['type'])) {
                $control['type'] = 'input';
            }
            if (!empty($control['label'])) {
                $control['label'] = array(
                    'text' => $control['label'],
                    'escape' => false
                );
                if (!empty($control['required'])) {
                    $control['label']['text'] .= '<span class="input-required">*</span>';
                }
            }
            if (isset($control['required'])) {
                unset($control['required']);
            }
            if (!empty($control['image']) && !empty($control['value']) && is_string($control['value'])) {
                $imageUrl = $this->Common->thumb($control['value'], '');
                $image = "<div style=\"margin-top:5px;max-width:120px;\"><a data-lightbox=\"lightbox-update-form\" href=\"{$imageUrl}\" class=\"js-thumb\">" . $this->Html->image($imageUrl, array('style' => 'width:120px')) . "</a>";
                if (!empty($control['allowEmpty'])) {
                    $image .= "<br/><input name=\"{$control['id']}[remove]\" type=\"checkbox\" value=\"1\"/>&nbsp;" . __('Remove');
                    unset($control['allowEmpty']);
                }
                if (!empty($control['crop'])) {
                    $imageInfo = base64_encode(json_encode($control['crop']));
                    $image .= "<a href=\"{$imageInfo}\" class=\"crop-img\">&nbsp;" . __('Edit') . "</a>";
                    unset($control['allowCrop']);
                }
                $image .= "<div class=\"cls\"></div>";
                $image .= "</div>";
                $control['templateVars'] = array(
                    'after' => $image
                );
                unset($control['image']);
                unset($control['value']);
            }
            if (!empty($control['video']) && !empty($control['value']) && is_string($control['value'])) {
                if (!empty($control['allowEmpty'])) {
                    $control['value'] .= "<br/><input name=\"{$control['id']}[remove]\" type=\"checkbox\" value=\"1\"/>&nbsp;" . __('Remove');
                    unset($control['allowEmpty']);
                }
                $control['after'] = "<div style=\"margin-top:5px;\">{$control['value']}</div>";
                unset($control['video']);
                unset($control['value']);
            }
            $id = !empty($control['id']) ? $control['id'] : microtime() . rand(1000, 9999);
            $controlType = $control['type'];
            if ($controlType == 'submit') {
                $btnCount++;
                continue;
            }
            if ($controlType !== 'file' && $controlType !== 'hidden' && $controlType !== 'password') {
                unset($control['type']);
            }
            if ($controlType == 'label') {
                $html .= $this->Form->label($id, implode(' ', $control));
            } elseif ($controlType == 'submit') {
                $html .= $this->Form->submit($control['value'], $control);
            } elseif ($controlType == 'password') {
                $html .= $this->Form->input($control['id'], $control);
            } elseif ($controlType == 'textarea') {
                $html .= '<div class="form-group">';
                $html .= '<label>' . $control['label']['text'] . '</label>';
                $html .= $this->Form->textarea($control['id'], $control);
                $html .= '</div>';
            } elseif ($controlType == 'editor') {
                $html .= $this->Common->editor($control);
            } elseif ($controlType == 'checkbox') {
                $html .= $this->Form->input($control['id'], array_merge($control, array('type' => 'checkbox')));
            } elseif (isset($control['phone'])) {
                // Phone custom
                $control['placeholder'] = '03-6715-1640';
                $html .= $this->Form->Input($control['id'],
                    array_merge(
                        array(
                            'class'         => 'phoneInput form-control',
                            'data-errorId'  => "idError{$control['id']}",
                            'after'         => "<div class='control-label' id='idError{$control['id']}' style='display: none;'>".__('Phone is invalid')."</div>"
                            ), $control
                        )
                );
                unset($control['phone']);
            } elseif ($controlType == 'calendar_from_to' || $controlType == 'text_from_to') {// KienNH 2016/03/07 add new type for search from - to
                $_from = $id . '_from';
                $_to = $id . '_to';
                $_separator = 'form_from_to_separator';
                $_from_value = !empty($this->request->data[$_from]) ? $this->request->data[$_from] : (!empty($this->request->query[$_from]) ? $this->request->query[$_from] : '');
                $_to_value = !empty($this->request->data[$_to]) ? $this->request->data[$_to] : (!empty($this->request->query[$_to]) ? $this->request->query[$_to] : '');
                
                $html .= '<div class="form-group FormFromToContainer">';
                $html .= $this->Form->label($id, $control['label']);
                
                $html .= $this->Form->input($_from, array(
                    'label' => false,
                    'id' => $_from,
                    'value' => $_from_value
                ));
                $html .= '<span class="' . $_separator . '">〜</span>';
                $html .= $this->Form->input($_to, array(
                    'label' => false,
                    'id' => $_to,
                    'value' => $_to_value,
                ));
                
                if ($controlType == 'calendar_from_to') {
                    $html .= "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $(\"#{$_from}, #{$_to}\").datepicker({
                            format: 'yyyy-mm-dd',
                            clearBtn: true,
                            todayHighlight: true,
                            autoclose: true,
                            language: 'ja',
                        }).on('changeDate', function () {
                            $(this).datepicker('hide');
                        });
                    });
                    </script>";
                }
                
                $html .= '</div>';
            } else {
                if (isset($control['autocomplete']) && !empty($control['options'])) {
                    $v = json_encode(array_values($control['options']));
                    if (isset($control['callback'])) {
                        $control['callback'] = "{$control['callback']}(ui.item)";
                    } else {
                        $control['callback'] = '';
                    }
                    $html .= "
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var js_{$control['id']}={$v};
                        $(\"#{$control['id']}\").autocomplete({
                            source: js_{$control['id']},
                            select: function(event, ui) {
                                {$control['callback']}
                            },
                        });
                    });
                    </script>";
                    $control['autocomplete'] = 'off';
                    unset($control['options']);
                    unset($control['callback']);
                    if (isset($control['empty']))
                        unset($control['empty']);
                }
                if (isset($control['autocomplete_combobox']) && !empty($control['options'])) {
                    $html .= "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $(\"#{$control['id']}\").combobox();
                    });
                    </script>";
                    unset($control['autocomplete_combobox']);
                    $control['autocomplete'] = 'off';
                }
                if (isset($control['autocomplete_ajax']) && !empty($control['options'])) {
                    $html .= "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        autocomplete(\"{$control['id']}\", \"{$control['options']['url']}\", {$control['options']['callback']});
                    });
                    </script>";
                    unset($control['autocomplete_ajax']);
                    unset($control['options']);
                    $control['autocomplete'] = 'off';
                }
                if (isset($control['calendar'])) {
                    $html .= "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $(\"#{$control['id']}\").datepicker({
                            format: 'yyyy-mm-dd',
                            clearBtn: true,
                            todayHighlight: true,
                            language: 'ja',
                        }).on('changeDate', function () {
                            $(this).datepicker('hide');
                        });
                    });
                    </script>";
                    unset($control['calendar']);
                }
                if (isset($control['timepicker'])) {
                    $html .= "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $(\"#{$control['id']}\").timepicker({
                            showInputs: false,
                            showMeridian: false,
                            minuteStep: 5,
                        });
                    });
                    </script>";
                    unset($control['timepicker']);
                }
                //datetime
                if (isset($control['datetime'])) {
                    $valdate =json_encode( empty($control['value'])?null:$control['value']);
                    $html .=  "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        $(\".{$control['id']}\").datetimepicker({
                            format: 'YYYY-MM-DD HH:mm',
                            showTodayButton:true,
                            showClear:true,
                            showClose:true,
                            locale: 'ja',
                            stepping:1,
                            date:{$valdate}
                        });
                    });
                    </script>";
                    unset($control['datetime']);
                }
               
                // KienNH 2016/08/17 begin
                if (isset($control['add_select_all']) && $control['add_select_all']) {
                    $tmp_id = microtime(true);
                    $html .= '<div class="form-group form-group-scroll">';
                    $html .= '<label>' . $control['label'] . '</label>';
                    
                    $html .= '<div class="form-control form-control-select-all">';
                    $html .= '<input type="checkbox" id="' . $tmp_id . '" class="checkbox_select_all" data-target="' . $control['id'] . '[]">';
                    $html .= '<label for="' . $tmp_id . '">' . __('All') . '</label>';
                    $html .= '</div>';
                    
                    $control['label'] = false;
                    $html .= $this->Form->input($id, $control);
                    $html .= '</div>';
                }else if(isset($control['multiple_select']) && $control['multiple_select']){
                    $tmp_id = microtime(true);
                    $html .= '<div class="form-group form-group-scroll">';
                    $html .= '<label>' . $control['label']['text'] . '</label>';
                    
                    $html .= '<div class="form-control form-control-select-all" style="padding:10px;border:none;">';
                    $html .= '<input onclick="checkAll(\'instagram_username[]\', this.checked ? 1 : 0)" type="checkbox" id="' . $tmp_id . '" class="checkbox_select_all" data-target="' . $control['id'] . '[]">';
                    $html .= '<label for="' . $tmp_id . '">' . __('All') . '</label>';
                    $html .= '</div>';
                    
                    $control['label'] = false;
                    $html .= $this->Form->input($id, $control);
                    $html .= '</div>';
                } else {
                    $html .= $this->Form->input($id, $control);
                }
                // KienNH end
            }
        }
        if ($btnCount > 0) {
            $html .= "<div class=\"form-group button-group\">";
            foreach ($form['elements'] as $control) {
                if (empty($control['type']) || $control['type'] != 'submit') {
                    continue;
                }
                if (isset($control['type'])) {
                    unset($control['type']);
                }
                $html .= $this->Form->submit($control['value'], $control);
            }
            $html .= "<div class=\"cls\"></div>";
            $html .= "</div>";
        }
        $html .= $this->Form->end();
        $html .= "<div class=\"cls\"></div>";
        $html .= "</div>";
        return $html;
    }

}
