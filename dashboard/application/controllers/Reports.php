<?php ob_start();
ini_set('memory_limit', '-1');
//ini_set('memory_limit', '512M');
ini_set('sqlsrv.ClientBufferMaxKBSize', '5242888'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '5242888');
header('Content-type: text/html; charset=utf-8');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('mprojects');
        $this->load->library('session');
        $this->load->library('tcpdf');
        $this->load->helper('string');
        $this->load->model('msection');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    function index()
    {
        $MProjects = new MProjects();
        $data = array();
        $data['projects'] = $MProjects->getAllProjects();
        $this->load->view('include/header');
        $this->load->view('include/sidebar');
        $this->load->view('reports', $data);
        $this->load->view('include/footer');
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Reports",
            "action" => "View Reports -> Function: Reports/index()",
            "result" => "view success",
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function getXmlDataBinding()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);

            $MProjects = new MProjects();
            $project = $MProjects->getEditProject($searchData['idProjects']);
            $MSection = new MSection();
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            if (isset($project[0]->short_title) && $project[0]->short_title != '') {
                $xml_layout_name = strtolower($this->clean($project[0]->short_title));
            } else {
                $xml_layout_name = 'myactivity';
            }
            $xml = '<layout xmlns:android="http://schemas.android.com/apk/res/android"  xmlns:tools="http://schemas.android.com/tools" xmlns:app="http://schemas.android.com/apk/res-auto"> 
                        <data> 
                            <import type="android.view.View" />  
                            <variable
                                name="form"
                                type="edu.aku.hassannaqvi.databinding.Form"/>
                        </data>  

                        <ScrollView
                            android:layout_width="match_parent"
                            android:layout_height="wrap_content">
                            
                            <LinearLayout android:id="@+id/GrpName" 
                                android:layout_width="match_parent"
                                android:layout_height="wrap_content"
                                android:orientation="vertical">';
            foreach ($data as $key => $value) {
                $searchData['idSectionDetail'] = $value->idSectionDetail;
                $getSkips = $MSection->getSkips($searchData);
                $cntSkip = count($getSkips);
                $skip = '';
                if (isset($getSkips) && $getSkips != '' && $cntSkip >= 1) {
                    $skip .= 'android:visibility="@{form.';
                    foreach ($getSkips as $skips_key => $skips_value) {
                        $skpVar = (isset($skips_value->skip_var) && $skips_value->skip_var != '' ? $skips_value->skip_var : '');
                        $skpVal = (isset($skips_value->skip_value) && $skips_value->skip_value != '' ? $skips_value->skip_value : '');
                        $skpGate = (isset($skips_value->skip_gate) && $skips_value->skip_gate != '' ? $skips_value->skip_gate : '');
                        if ($skips_key == 0) {
                            $skip .= strtolower($skpVar) . '.equals(`' . $skpVal . '`) ';
                        } else {
                            if ($skpGate == 'AND') {
                                $skip .= ' &amp;&amp; ' . strtolower($skpVar) . '.equals(`' . $skpVal . '`) ';
                            } elseif ($skpGate == 'OR') {
                                $skip .= ' || ' . strtolower($skpVar) . '.equals(`' . $skpVal . '`) ';
                            }
                        }
                    }
                    $skip .= ' ? View.VISIBLE : View.GONE}"';
                }
                $xml .= "\n\n" . ' <!-- ' . strtolower($value->variable_name) . '  ' . $value->nature . '   -->' . "\n";
                $xml .= '<androidx.cardview.widget.CardView
                            android:id="@+id/fldGrpCV' . strtolower($value->variable_name) . '"
                            style="@style/cardView"
                            ' . $skip . '>
                
                <LinearLayout
                    android:layout_width="match_parent"
                    android:layout_height="wrap_content"
                    android:orientation="vertical" >';
                if ($value->nature == 'Title') {
                    $rl = ' <TextView
                        android:layout_width="match_parent"
                        android:layout_height="wrap_content"
                        android:text="@string/' . strtolower($value->variable_name) . '" />';
                }
                else {
                    $rl = '<LinearLayout
                            android:layout_width="match_parent"
                            android:layout_height="wrap_content"
                            android:background="@drawable/bottom"
                            android:orientation="horizontal">
                            
                                <TextView
                                    style="@style/quesNum"
                                    android:layout_width="wrap_content"
                                    android:layout_height="match_parent"
                                    android:text="@string/Q_' . strtolower($value->variable_name) . '"  />
                                    
                                <TextView
                                    android:layout_width="match_parent"
                                    android:layout_height="match_parent"
                                    android:text="@string/' . strtolower($value->variable_name) . '" />
                                        
                            </LinearLayout>
                            ';
                }

                $xml .= $rl;
                if ($value->nature == 'Input-Numeric') {
                    $maxValue = 'app:maxValue="0"';
                    $minValue = 'app:minValue="0"';
                    $maxLength_o = 'android:maxLength="1"';
                    if (isset($value->MaxVal) && $value->MaxVal != '') {
                        $maxValue = 'app:maxValue="' . $value->MaxVal . '"';
                        $maxLength_o = 'android:maxLength="' . strlen($value->MaxVal) . '"';
                    }
                    if (isset($value->MinVal) && $value->MinVal != '') {
                        $minValue = 'app:minValue="' . $value->MinVal . '"';
                    }

                    $xml .= '<com.edittextpicker.aliazaz.EditTextPicker
                                    android:id="@+id/' . strtolower($value->variable_name) . '"
                                    android:layout_width="match_parent"
                                    android:layout_height="wrap_content" 
                                    android:hint="@string/' . strtolower($value->variable_name) . '" 
                                    android:inputType="number" 
                                   ' . $maxLength_o . '
                                   ' . $maxValue . '
                                   ' . $minValue . '
                                    app:type="range"
                                    android:text="@={form.' . strtolower($value->variable_name) . '}" />';
                }
                elseif ($value->nature == 'Input') {
                    $xml .= '<EditText
                                    android:id="@+id/' . strtolower($value->variable_name) . '" 
                                    android:layout_width="match_parent"
                                    android:layout_height="wrap_content" 
                                    android:digits="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789,. "
                                    android:hint="@string/' . strtolower($value->variable_name) . '"
                                    android:text="@={form.' . strtolower($value->variable_name) . '}" />';
                }
                elseif ($value->nature == 'Date') {
                    $xml .= '<io.blackbox_vision.datetimepickeredittext.view.DatePickerEditText
                                android:id="@+id/' . strtolower($value->variable_name) . '"
                                android:layout_width="match_parent"
                                android:layout_height="wrap_content"
                                android:gravity="center"
                                android:hint="DD-MM-YYYY"
                                app:dateFormat="dd-MM-yyyy"
                                app:maxDate="CR_DATE"
                                app:minDate="CR_DATE"
                                app:theme="@style/DatePickerStyle" />';
                }
                elseif ($value->nature == 'Time') {
                    $xml .= ' <io.blackbox_vision.datetimepickeredittext.view.TimePickerEditText
                                    android:id="@+id/' . strtolower($value->variable_name) . '"
                                    android:layout_width="match_parent"
                                    android:layout_height="wrap_content"
                                    android:focusable="false"
                                    android:gravity="center"
                                    android:hint="HH:mm"
                                    app:theme="@style/DatePickerStyle" />';
                }


                if (isset($value->myrow_options) && $value->myrow_options != '') {
                    if ($value->nature == 'Dropdown') {
                        $xml .= '<androidx.appcompat.widget.AppCompatSpinner
                                android:id="@+id/' . strtolower($value->variable_name) . '"
                                android:layout_width="match_parent"
                                android:layout_height="match_parent"
                                android:minHeight="56dp"
                                android:prompt="@string/variableName"
                                android:spinnerMode="dropdown" />';
                    }
                    if ($value->nature == 'Radio') {
                        $xml .= '<RadioGroup
                        android:id="@+id/' . strtolower($value->variable_name) . '"
                        android:layout_width="match_parent"
                        android:layout_height="wrap_content">';
                    }
                    if ($value->nature == 'CheckBox') {
                        $xml .= '<LinearLayout
                                android:id="@+id/' . strtolower($value->variable_name) . 'check"
                                android:layout_width="match_parent"
                                android:layout_height="wrap_content"
                                android:orientation="vertical"
                                android:tag="0">';
                    }
                    $s = 0;
                    foreach ($value->myrow_options as $options) {

                        $s++;
                        if ($value->nature == 'Radio' && $options->nature == 'Input') {
                            $xml .= '<RadioButton
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent" 
                                        android:layout_height="wrap_content"
                                        android:checked="@{form.' . strtolower($value->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($value->variable_name)) . '(`' . $options->option_value . '`)}" 
                                        />
                                        <EditText
                                            android:id="@+id/' . strtolower($options->variable_name) . 'x" 
                                            android:layout_width="match_parent"
                                            android:layout_height="wrap_content"
                                            android:hint="@string/' . strtolower($options->variable_name) . '"
                                            android:digits="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789,. "
                                            android:tag="' . strtolower($options->variable_name) . '"
                                            android:text="@={form.' . strtolower($options->variable_name) . 'x}"
                                            android:visibility="@{form.' . strtolower($value->variable_name) . '.equals(`' . $options->option_value . '`) ? View.VISIBLE : View.GONE}"
                                            />';
                        }
                        elseif ($value->nature == 'Radio' && $options->nature == 'Input-Numeric') {
                            $maxVal_o = 'app:maxValue="0"';
                            $minVal_o = 'app:minValue="0"';
                            $maxLength_o = 'android:maxLength="1"';
                            if (isset($options->MaxVal) && $options->MaxVal != '') {
                                $maxVal_o = 'app:maxValue="' . $options->MaxVal . '"';
                                $maxLength_o = 'android:maxLength="' . strlen($options->MaxVal) . '"';
                            }
                            if (isset($options->MinVal) && $options->MinVal != '') {
                                $minVal_o = 'app:minValue="' . $options->MinVal . '"';
                            }
                            $xml .= '<RadioButton
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent" 
                                        android:layout_height="wrap_content"
                                        android:checked="@{form.' . strtolower($value->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($value->variable_name)) . '(`' . $options->option_value . '`)}"
                                        />
                                         <com.edittextpicker.aliazaz.EditTextPicker
                                            android:id="@+id/' . strtolower($options->variable_name) . 'x" 
                                            android:layout_width="match_parent"
                                            android:layout_height="wrap_content"
                                            android:hint="@string/' . strtolower($options->variable_name) . '"
                                            android:tag="' . strtolower($options->variable_name) . '"
                                            android:inputType="number" 
                                            ' . $maxLength_o . '
                                            ' . $maxVal_o . '
                                            ' . $minVal_o . '
                                            app:type="range" 
                                            android:text="@={form.' . strtolower($options->variable_name) . 'x}"
                                            android:visibility="@{form.' . strtolower($value->variable_name) . '.equals(`' . $options->option_value . '`) ? View.VISIBLE : View.GONE}"
                                            />';
                        }
                        elseif ($value->nature == 'Radio' && $options->nature == 'Date') {
                            $xml .= '<RadioButton
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent" 
                                        android:layout_height="wrap_content"
                                        android:checked="@{form.' . strtolower($value->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($value->variable_name)) . '(`' . $options->option_value . '`)}"
                                        />
                                        <io.blackbox_vision.datetimepickeredittext.view.DatePickerEditText
                                                android:id="@+id/' . strtolower($options->variable_name) . 'x"
                                                android:layout_width="match_parent"
                                                android:layout_height="wrap_content"
                                                android:gravity="center"
                                                android:hint="DD-MM-YYYY"
                                                app:dateFormat="dd-MM-yyyy"
                                                app:maxDate="CR_DATE"
                                                app:minDate="CR_DATE"
                                                app:theme="@style/DatePickerStyle" />';
                        }
                        elseif ($value->nature == 'Radio' && $options->nature == 'Time') {
                            $xml .= '<RadioButton
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent" 
                                        android:layout_height="wrap_content"
                                        android:checked="@{form.' . strtolower($value->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($value->variable_name)) . '(`' . $options->option_value . '`)}"
                                        />
                                         <io.blackbox_vision.datetimepickeredittext.view.TimePickerEditText
                                            android:id="@+id/' . strtolower($options->variable_name) . 'x"
                                            android:layout_width="match_parent"
                                            android:layout_height="wrap_content"
                                            android:focusable="false"
                                            android:gravity="center"
                                            android:hint="HH:mm"
                                            app:theme="@style/DatePickerStyle" />';
                        }
                        elseif ($value->nature == 'CheckBox' && $options->nature == 'Input') {
                            $xml .= '<CheckBox
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"
                                        android:checked="@{form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($options->variable_name)) . '(form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)?``:`' . $options->option_value . '`)}"
                                         />                        
                                        <EditText
                                            android:id="@+id/' . strtolower($options->variable_name) . 'x" 
                                            android:layout_width="match_parent"
                                            android:layout_height="wrap_content" 
                                            android:hint="@string/' . strtolower($options->variable_name) . '"
                                            android:digits="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789,. "
                                            android:tag="' . strtolower($options->variable_name) . '"
                                            android:text="@={form.' . strtolower($options->variable_name) . 'x}"
                                            android:visibility="@{form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`) ? View.VISIBLE : View.GONE}"
                                             />';
                        }
                        elseif ($value->nature == 'CheckBox' && $options->nature == 'Input-Numeric') {

                            $maxVal_o = 'app:maxValue="0"';
                            $minVal_o = 'app:minValue="0"';
                            $maxLength_o = 'android:maxLength="1"';
                            if (isset($options->MaxVal) && $options->MaxVal != '') {
                                $maxVal_o = 'app:maxValue="' . $options->MaxVal . '"';
                                $maxLength_o = 'android:maxLength="' . strlen($options->MaxVal) . '"';
                            }
                            if (isset($options->MinVal) && $options->MinVal != '') {
                                $minVal_o = 'app:minValue="' . $options->MinVal . '"';
                            }
                            $xml .= '<CheckBox
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content" android:checked="@{form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($options->variable_name)) . '(form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)?``:`' . $options->option_value . '`)}"
                                        />                        
                                        <com.edittextpicker.aliazaz.EditTextPicker
                                            android:id="@+id/' . strtolower($options->variable_name) . 'x" 
                                            android:layout_width="match_parent"
                                            android:layout_height="wrap_content"  
                                            android:hint="@string/' . strtolower($options->variable_name) . '"
                                            android:tag="' . strtolower($options->variable_name) . '"
                                             android:inputType="number" 
                                            ' . $maxLength_o . '
                                            ' . $maxVal_o . '
                                            ' . $minVal_o . '
                                            app:type="range" 
                                            android:text="@={form.' . strtolower($options->variable_name) . 'x}"
                                            android:visibility="@{form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`) ? View.VISIBLE : View.GONE}"
                                             />';
                        }
                        elseif ($value->nature == 'CheckBox' && $options->nature == 'Date') {

                            $xml .= '<CheckBox
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content" android:checked="@{form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($options->variable_name)) . '(form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)?``:`' . $options->option_value . '`)}"
                                        />                        
                                        <io.blackbox_vision.datetimepickeredittext.view.DatePickerEditText
                                                android:id="@+id/' . strtolower($options->variable_name) . 'x"
                                                android:layout_width="match_parent"
                                                android:layout_height="wrap_content"
                                                android:gravity="center"
                                                android:hint="DD-MM-YYYY"
                                                app:dateFormat="dd-MM-yyyy"
                                                app:maxDate="CR_DATE"
                                                app:minDate="CR_DATE"
                                                app:theme="@style/DatePickerStyle" />';
                        }
                        elseif ($value->nature == 'CheckBox' && $options->nature == 'Time') {
                            $xml .= '<CheckBox
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content" android:checked="@{form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($options->variable_name)) . '(form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)?``:`' . $options->option_value . '`)}"
                                        />                        
                                        <io.blackbox_vision.datetimepickeredittext.view.TimePickerEditText
                                        android:id="@+id/' . strtolower($options->variable_name) . 'x"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"
                                        android:focusable="false"
                                        android:gravity="center"
                                        android:hint="HH:mm"
                                        app:theme="@style/DatePickerStyle" />';
                        }
                        elseif ($options->nature == 'Input-Numeric') {
                            $maxVal = 'app:maxValue="0"';
                            $minVal = 'app:minValue="0"';
                            $maxLength_o = 'android:maxLength="1"';
                            if (isset($options->MaxVal) && $options->MaxVal != '') {
                                $maxVal = 'app:maxValue="' . $options->MaxVal . '"';
                                $maxLength_o = 'android:maxLength="' . strlen($options->MaxVal) . '"';
                            }
                            if (isset($options->MinVal) && $options->MinVal != '') {
                                $minVal = 'app:minValue="' . $options->MinVal . '"';
                            }
                            $xml .= '<TextView 
                                        android:text="@string/' . strtolower($options->variable_name) . '"  
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"  />
                                        <com.edittextpicker.aliazaz.EditTextPicker
                                                android:layout_width="match_parent"
                                                android:layout_height="wrap_content"
                                                android:id="@+id/' . strtolower($options->variable_name) . '"
                                                android:hint="@string/' . strtolower($options->variable_name) . '"  
                                                android:inputType="number" 
                                                ' . $maxLength_o . '
                                                ' . $maxVal . '
                                                ' . $minVal . '
                                                app:type="range" 
                                                android:text="@={form.' . strtolower($options->variable_name) . '}"/>';
                        }
                        elseif ($options->nature == 'Input') {
                            $xml .= '<TextView 
                                        android:text="@string/' . strtolower($options->variable_name) . '" 
                                        android:layout_marginTop="12dp" 
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"  />
                                        <EditText
                                            android:id="@+id/' . strtolower($options->variable_name) . '" 
                                            android:layout_width="match_parent"
                                            android:layout_height="wrap_content"  
                                            android:digits="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789,. " 
                                            android:text="@={form.' . strtolower($options->variable_name) . '}"
                                            android:hint="@string/' . strtolower($options->variable_name) . '" />';
                        }
                        elseif ($options->nature == 'Title') {
                            $xml .= '<TextView 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_marginTop="12dp"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"   />';
                        }
                        elseif ($options->nature == 'Radio') {
                            $xml .= '<RadioButton
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"  
                                        android:checked="@{form.' . strtolower($value->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($value->variable_name)) . '(`' . $options->option_value . '`)}"
                                        /> ';
                        }
                        elseif ($options->nature == 'CheckBox') {
                            $checked_97_98 = '';
                            $chk = 0;
                            foreach ($value->myrow_options as $checking) {
                                if ($checking->option_value == 97) {
                                    $chk++;
                                    $checked_97_98 = 'android:enabled="@{!form.' . strtolower($checking->variable_name) . '.equals(`' . $checking->option_value . '`)}"';

                                } else if ($checking->option_value == 98) {
                                    $chk++;
                                    $checked_97_98 = 'android:enabled="@{!form.' . strtolower($checking->variable_name) . '.equals(`' . $checking->option_value . '`)}"';
                                } else if ($checking->option_value == 99) {
                                    $chk++;
                                    $checked_97_98 = 'android:enabled="@{!form.' . strtolower($checking->variable_name) . '.equals(`' . $checking->option_value . '`)}"';
                                }
                                if ($chk == 2) {
                                    $checked_97_98 = 'android:enabled="@{!form.' . strtolower($value->variable_name) . '98.equals(`98`) &amp;&amp; !form.' . strtolower($value->variable_name) . '97.equals(`97`)}"';
                                } elseif ($chk == 3) {
                                    $checked_97_98 = 'android:enabled="@{!form.' . strtolower($value->variable_name) . '97.equals(`97`) &amp;&amp; !form.' . strtolower($value->variable_name) . '98.equals(`98`) &amp;&amp; !form.' . strtolower($value->variable_name) . '99.equals(`99`)}"';
                                }
                            }

                            $xml .= '<CheckBox
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content" 
                                        android:checked="@{form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)}"
                                        android:onClick="@{()->form.set' . ucfirst(strtolower($options->variable_name)) . '(form.' . strtolower($options->variable_name) . '.equals(`' . $options->option_value . '`)?``:`' . $options->option_value . '`)}"
                                      ' . $checked_97_98 . '  />';
                        }
                        elseif ($options->nature == 'Date') {
                            $xml .= '<io.blackbox_vision.datetimepickeredittext.view.DatePickerEditText
                                        android:id="@+id/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"
                                        android:gravity="center"
                                        android:hint="DD-MM-YYYY"
                                        app:dateFormat="dd-MM-yyyy"
                                        app:maxDate="CR_DATE"
                                        app:minDate="CR_DATE"
                                        app:theme="@style/DatePickerStyle" />';
                        }
                        elseif ($options->nature == 'Time') {
                            $xml .= '<io.blackbox_vision.datetimepickeredittext.view.TimePickerEditText
                                        android:id="@+id/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content"
                                        android:focusable="false"
                                        android:gravity="center"
                                        android:hint="HH:mm"
                                        app:theme="@style/DatePickerStyle" />';
                        }
                    }
                    if ($value->nature == 'Radio') {
                        $xml .= '</RadioGroup>';
                    }
                    if ($value->nature == 'CheckBox') {
                        $xml .= '</LinearLayout>';
                    }
                }
                $xml .= ' </LinearLayout>
            </androidx.cardview.widget.CardView>';
            }
            $xml .= '<!--EndButton LinearLayout-->
           <LinearLayout
                android:layout_width="match_parent"
                android:layout_height="wrap_content"
                android:layout_gravity="end"
                android:layout_marginTop="24dp"
                android:orientation="horizontal">
                   <Button
                        android:id="@+id/btn_End"
                        android:layout_width="wrap_content"
                        android:layout_height="wrap_content"
                        android:layout_marginStart="12dp"
                        android:onClick="@{() -> callback.BtnEnd()}"
                        android:background="@color/red_overlay"
                        android:textColor="@color/white"
                        android:text="Cancel" />
                   <Button
                        android:id="@+id/btn_Continue"
                        android:layout_width="wrap_content"
                        android:layout_height="wrap_content"
                        android:layout_marginStart="12dp"
                        android:onClick="@{() -> callback.BtnContinue()}"
                        android:background="@color/green_overlay"
                        android:textColor="@color/white"
                        android:text="Save" /> 
            </LinearLayout>';
            $xml .= '</LinearLayout>
    </ScrollView>
</layout>';
            $file = "assets/uploads/myfiles/myactivity.xml";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $xml);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/xml");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select project';
        }
    }

    function getXml()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $xml_layout_name = 'Myactivity';
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $xml = ' <layout xmlns:android="http://schemas.android.com/apk/res/android"  xmlns:tools="http://schemas.android.com/tools" 
  xmlns:app="http://schemas.android.com/apk/res-auto"> 
    <data> 
        <import type="android.view.View" /> 
        <variable name="callback" type="edu.aku.hassannaqvi.template.ui.' . $xml_layout_name . '" />
    </data> 
    <ScrollView   android:fadeScrollbars="false"  android:fillViewport="true" 
    android:layout_width="match_parent"
    android:layout_height="wrap_content" 
    android:scrollbarSize="10dip" tools:context=".ui.' . $xml_layout_name . '">
   <LinearLayout android:id="@+id/GrpName" android:layout_width="match_parent"  android:layout_height="wrap_content"android:orientation="vertical"> ';

            foreach ($data as $key => $value) {
                $xml .= "\n\n" . ' <!--' . strtolower($value->variable_name) . '  ' . $value->nature . '-->' . "\n";
                $xml .= '<androidx.cardview.widget.CardView
                android:id="@+id/fldGrpCV' . strtolower($value->variable_name) . '"
                android:layout_width="match_parent"
                android:layout_height="wrap_content">
                <LinearLayout
                    android:layout_width="match_parent"
                    android:layout_height="wrap_content"
                    android:orientation="vertical">
                    <TextView 
                        android:text="@string/' . strtolower($value->variable_name) . '" 
                        android:layout_width="match_parent"
                        android:layout_height="56dp"  
                        android:layout_marginTop="12dp"
                />';
                if (isset($value->myrow_options) && $value->myrow_options != '') {
                    if ($value->nature == 'Radio') {
                        $xml .= ' <RadioGroup
                        android:id="@+id/' . strtolower($value->variable_name) . '"
                        android:layout_width="match_parent"
                        android:layout_height="wrap_content"> ';
                    }
                    if ($value->nature == 'CheckBox') {
                        $xml .= ' <LinearLayout
                                android:id="@+id/' . strtolower($value->variable_name) . 'check"
                                android:layout_width="match_parent"
                                android:layout_height="wrap_content"
                                android:orientation="vertical"
                                android:tag="0"> ';
                    }
                    foreach ($value->myrow_options as $options) {
                        if ($value->nature == 'Radio' && ($options->nature == 'Input' || $options->nature == 'Input - Numeric')) {
                            $xml .= ' <RadioButton
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content" />
                            <EditText
                            android:id="@+id/' . strtolower($options->variable_name) . 'x" 
                            android:layout_width="match_parent"
                            android:layout_height="56dp" 
                            android:layout_marginBottom="12dp"
                            android:hint="@string/' . strtolower($options->variable_name) . '"
                            android:tag="' . strtolower($options->variable_name) . '"
                            android:text = \'@{' . strtolower($options->variable_name) . '.checked? ' . strtolower($options->variable_name) . 'x.getText().toString() : ""}\'
                            android:visibility=\'@{' . strtolower($options->variable_name) . '.checked? View.VISIBLE : View.GONE}\' />';
                        } elseif
                        ($value->nature == 'CheckBox' && ($options->nature == 'Input' || $options->nature == 'Input-Numeric')) {
                            $xml .= '<CheckBox
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                         android:layout_width="match_parent"
                                        android:layout_height="wrap_content" />                       
                            <EditText
                            android:id="@+id/' . strtolower($options->variable_name) . 'x" 
                            android:layout_width="match_parent"
                            android:layout_height="56dp" 
                            android:layout_marginBottom="12dp"
                            android:hint="@string/' . strtolower($options->variable_name) . '"
                            android:tag="' . strtolower($options->variable_name) . '"
                            android:text=\'@{' . strtolower($options->variable_name) . '.checked? ' . strtolower($options->variable_name) . 'x.getText().toString() : ""}\'
                            android:visibility=\'@{' . strtolower($options->variable_name) . '.checked? View.VISIBLE : View.GONE}\' />';
                        } elseif
                        ($options->nature == 'Input-Numeric') {
                            $minVal = 0;
                            $maxVal = 0;

                            if (isset($options->MaxVal) && $options->MaxVal != '') {
                                $maxVal = $options->MaxVal;
                            }
                            if (isset($options->MinVal) && $options->MinVal != '') {
                                $minVal = $options->MinVal;
                            }
                            $xml .= '<TextView 
                        android:text="@string/' . strtolower($options->variable_name) . '" 
                          android:layout_marginTop="12dp"
                          android:layout_width="match_parent"
                        android:layout_height="56dp"  />
                            <com.edittextpicker.aliazaz.EditTextPicker
                            android:layout_width="match_parent"
                            android:layout_height="56dp" 
                            android:layout_marginBottom="12dp"
                                    android:id="@+id/' . strtolower($options->variable_name) . '"
                                    android:hint="@string/' . strtolower($options->variable_name) . '" 
                                    app:mask="##"
                                    app:maxValue="' . $maxVal . '"
                                    app:minValue="' . $minVal . '"
                                    app:type="range"
                                     />';
                        } elseif
                        ($options->nature == 'Input') {
                            $xml .= '<TextView 
                        android:text="@string/' . strtolower($options->variable_name) . '" 
                         android:layout_marginTop="12dp" 
                         android:layout_width="match_parent"
                        android:layout_height="56dp"  />
                            <EditText
                                android:id="@+id/' . strtolower($options->variable_name) . '" 
                                android:layout_width="match_parent"
                                android:layout_height="56dp"  
                                android:layout_marginBottom="12dp"
                                android:hint="@string/' . strtolower($options->variable_name) . '" 
                                 />';
                        } elseif
                        ($options->nature == 'Title') {
                            $xml .= '  <TextView 
                        android:text="@string/' . strtolower($options->variable_name) . '"
                         android:layout_marginTop="12dp"
                         android:layout_width="match_parent"
                        android:layout_height="56dp"   />';
                        } elseif
                        ($options->nature == 'Radio') {
                            $xml .= '<RadioButton
                                        android:id="@+id/' . strtolower($options->variable_name) . '" 
                                        android:text="@string/' . strtolower($options->variable_name) . '"
                                        android:layout_width="match_parent"
                                        android:layout_height="wrap_content" />';
                        } elseif
                        ($options->nature == 'CheckBox') {
                            $xml .= ' <CheckBox
                            android:id="@+id/' . strtolower($options->variable_name) . '" 
                            android:text="@string/' . strtolower($options->variable_name) . '"
                            android:layout_width="match_parent"
                            android:layout_height="wrap_content" />';
                        }
                    }
                    if ($value->nature == 'Radio') {
                        $xml .= '</RadioGroup>';
                    }

                    if ($value->nature == 'CheckBox') {
                        $xml .= '</LinearLayout>';
                    }
                } else {
                    if ($value->nature == 'Input-Numeric') {
                        $minVal = 0;
                        $maxVal = 0;
                        if (isset($value->MaxVal) && $value->MaxVal != '') {
                            $maxVal = $value->MaxVal;
                        }
                        if (isset($value->MinVal) && $value->MinVal != '') {
                            $minVal = $value->MinVal;
                        }
                        $xml .= '<com.edittextpicker.aliazaz.EditTextPicker
                                    android:id="@+id/' . strtolower($value->variable_name) . '"
                                    android:layout_width="match_parent"
                                    android:layout_height="56dp"  
                                    android:inputType="number"
                                     android:layout_marginBottom="12dp"
                                    android:hint="@string/' . strtolower($value->variable_name) . '"
                                    app:mask="##"
                                    app:maxValue="' . $maxVal . '"
                                    app:minValue="' . $minVal . '"
                                    app:type="range" />';
                    } elseif ($value->nature == 'Input') {
                        $xml .= '<EditText
                                android:id="@+id/' . strtolower($value->variable_name) . '" 
                                android:layout_width="match_parent"
                                android:layout_height="56dp" 
                                android:layout_marginBottom="12dp"
                                android:hint="@string/' . strtolower($value->variable_name) . '" 
                                 />';
                    } elseif ($value->nature == 'Title') {
                    }
                }
                $xml .= ' </LinearLayout>
            </androidx.cardview.widget.CardView>';
            }
            $xml .= '<LinearLayout
                android:layout_width="match_parent"
                android:layout_height="wrap_content"
                android:layout_gravity="end"
                android:layout_marginTop="24dp"
                android:orientation="horizontal">
                   <Button
                        android:id="@+id/btn_End"
                        android:layout_width="wrap_content"
                        android:layout_height="wrap_content"
                        android:layout_marginStart="12dp"
                        android:onClick="@{() -> callback.BtnEnd()}"
                        android:background="@color/red_overlay"
                        android:textColor="@color/white"
                        android:text="Cancel" />
                   <Button
                        android:id="@+id/btn_Continue"
                        android:layout_width="wrap_content"
                        android:layout_height="wrap_content"
                        android:layout_marginStart="12dp"
                        android:onClick="@{() -> callback.BtnContinue()}"
                        android:background="@color/green_overlay"
                        android:textColor="@color/white"
                        android:text="Save" /> 
            </LinearLayout>';
            $xml .= '</LinearLayout>
    </ScrollView>
</layout>';
            $file = "assets/uploads/myfiles/myactivity.xml";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $xml);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/xml");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select project';
        }
    }

    function getPDF()
    {
        if (isset($_REQUEST['project']) && $_REQUEST['project'] != '' && $_REQUEST['project'] != 0) {
            $idProject = $_REQUEST['project'];
            $this->load->model('mmodule');
            $this->load->model('msection');
            $MProjects = new MProjects();
            $MModule = new MModule();
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $idProject;
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $searchData['language'] = (isset($_REQUEST['language']) && $_REQUEST['language'] != '' ? $_REQUEST['language'] : 0);

            if ($searchData['language'] === 'l1') {
                $displaylanguagel1 = 'on';
                $displaylanguagel2 = 'off';
                $displaylanguagel3 = 'off';
                $displaylanguagel4 = 'off';
                $displaylanguagel5 = 'off';
            } elseif ($searchData['language'] === 'l2') {
                $displaylanguagel1 = 'off';
                $displaylanguagel2 = 'on';
                $displaylanguagel3 = 'off';
                $displaylanguagel4 = 'off';
                $displaylanguagel5 = 'off';
            } elseif ($searchData['language'] === 'l3') {
                $displaylanguagel1 = 'off';
                $displaylanguagel2 = 'off';
                $displaylanguagel3 = 'on';
                $displaylanguagel4 = 'off';
                $displaylanguagel5 = 'off';
            } elseif ($searchData['language'] === 'l4') {
                $displaylanguagel1 = 'off';
                $displaylanguagel2 = 'off';
                $displaylanguagel3 = 'off';
                $displaylanguagel4 = 'on';
                $displaylanguagel5 = 'off';
            } elseif ($searchData['language'] === 'l5') {
                $displaylanguagel1 = 'off';
                $displaylanguagel2 = 'off';
                $displaylanguagel3 = 'off';
                $displaylanguagel4 = 'off';
                $displaylanguagel5 = 'on';
            } else {
                $displaylanguagel1 = 'on';
                $displaylanguagel2 = 'on';
                $displaylanguagel3 = 'on';
                $displaylanguagel4 = 'on';
                $displaylanguagel5 = 'on';
            }
            $GetReportData = $MProjects->getPDFData($searchData);
            $project_name = $GetReportData[0]->project_name;
            $short_title = strtoupper($GetReportData[0]->short_title);
            $title = $project_name . ' (' . $short_title . ')';


            $getLastUpdatedDate = $MSection->getLastUpdatedDate($searchData);
            $lastUpdateDateTime = date('d-m-Y', strtotime($getLastUpdatedDate[0]->updateDateTime));
            $lastUpdateBy = (isset($getLastUpdatedDate[0]->fullName) && $getLastUpdatedDate[0]->fullName != '' ? $getLastUpdatedDate[0]->fullName : '');
            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF - 8', false, false, $lastUpdateDateTime, $lastUpdateBy);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Dictionary Portal');
            $pdf->SetTitle($title);
            $pdf->SetSubject($title);
            $pdf->SetKeywords($title);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetTopMargin(1);
            $pdf->setPrintHeader(false);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__) . ' / lang / eng . php')) {
                require_once(dirname(__FILE__) . ' / lang / eng . php');
            }
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('freeserif', '', 12);
            $style = "<style>
                        h1{text-align: center; font-size: 30px;  color: #002D57;}
                        h3{text-align: center; font-size: 22px;}
                        h4{font-size: 18px;}
                        small{font-size: 10px}   
                     </style>";
            foreach ($GetReportData as $projectsCrfs) {
                $searchData['idCRF'] = $projectsCrfs->id_crf;
                $crf_name = $projectsCrfs->crf_name;
                $crf_title = $crf_name . (isset($projectsCrfs->crf_title) && $projectsCrfs->crf_title != '' ? ' (' . strtoupper($projectsCrfs->crf_title) . ')' : '');
                $Mainheader = "<div class='head'>
                                    <h1 class='mainheading'>" . $title . "</h1>
                                    <h3 class='subheading'>" . $crf_title . "</h3>
                               </div>";
                $pdf->AddPage();
                $pdf->writeHTML($style . $Mainheader, true, false, true, false, 'centre');
                $getModules = $MModule->getModulesData($searchData);
                foreach ($getModules as $keyModule => $valueModule) {
                    $l = 0;
                    $subhtml = "<div class='moduleDiv'>";
                    if (isset($valueModule->module_name_l1) && $valueModule->module_name_l1 != '' &&
                        $displaylanguagel1 == 'on') {
                        $subhtml .= "<h4>" . htmlentities($valueModule->module_name_l1) . " : <small>" . $valueModule->module_desc_l1 . "</small></h4>";
                    }
                    if (isset($valueModule->module_name_l2) && $valueModule->module_name_l2 != '' &&
                        $displaylanguagel2 == 'on') {
                        $subhtml .= "<h4>" . $valueModule->module_name_l2 . "</h4>" .
                            (isset($valueModule->module_desc_l2) && $valueModule->module_desc_l2 != '' ? ' <h5>' . $valueModule->module_desc_l2 . ' </h5> ' : '');
                    }
                    if (isset($valueModule->module_name_l3) && $valueModule->module_name_l3 != '' &&
                        $displaylanguagel3 == 'on') {
                        $subhtml .= "<h4>" . $valueModule->module_name_l3 . "</h4><h5>" . $valueModule->module_desc_l3 . "</h5>";
                    }
                    if (isset($valueModule->module_name_l4) && $valueModule->module_name_l4 = '' &&
                            $displaylanguagel4 == 'on') {
                        $subhtml .= "<h4>" . $valueModule->module_name_l4 . "</h4><h5>" . $valueModule->module_desc_l4 . "</h5>";
                    }
                    if (isset($valueModule->module_name_l5) && $valueModule->module_name_l5 != '' &&
                        $displaylanguagel5 == 'on') {
                        $subhtml .= "<h4>" . $valueModule->module_name_l5 . " </h4><h5>" . $valueModule->module_desc_l5 . "</h5>";
                    }
                    $subhtml .= "</div>";
                    $ModuleSearchData = array();
                    $ModuleSearchData['idModule'] = $valueModule->idModule;
                    $ModuleSearchData['idSection'] = $searchData['idSection'];
                    $getSections = $MSection->getSectionData($ModuleSearchData);
                    foreach ($getSections as $keySection => $valueSection) {
                        $l++;
                        if (isset($valueSection->section_title) && $valueSection->section_title != '') {
                            $sectionHeading = $valueSection->section_var_name . ": " . htmlentities($valueSection->section_title) . " : " . $valueSection->section_desc;
                        }
                        if (isset($searchData['idSection']) && $searchData['idSection'] != 0) {
                            $ModuleSearchData['idSection'] = $searchData['idSection'];
                        } else {
                            $ModuleSearchData['idSection'] = $valueSection->idSection;
                        }
                        $getSectionDetails = $MSection->getSectionDetailData($ModuleSearchData);

                        $myresult = $this->questionArr($getSectionDetails);

                        $optionsubhtml = ' <style>table tr {
                font-size: 12px}  table tr th {
                font-size: 11px; font-weight: bold}
                                            .fright{ float:right}
                                            .myborder{background-color: lightsteelblue; font-size: 11px}
                                           </style> ';
                        if ($l == 1) {
                            $optionsubhtml .= $subhtml;
                        }
                        $optionsubhtml .= '<table border="1" cellpadding="1" cellspacing="0">
                                       <tr align="center">
                                                 <th colspan="4"> ' . $sectionHeading . '</th>
                                            </tr>
                                            <tr  align="center">
                                                <th width="12%"> Variable</th>
                                                <th width="45%"> Label</th> 
                                                <th width="36%"> Options</th>
                                                <th width="7%"> Other</th>
                                            </tr> ';
                        foreach ($myresult as $keySectionDetail => $valueSectionDetail) {
                            if (isset($valueSectionDetail->variable_name) && $valueSectionDetail->variable_name != '') {

                                $searchData['idSectionDetail'] = $valueSectionDetail->idSectionDetail;
                                $getSkips = $MSection->getSkips($searchData);
                                $cntSkip = count($getSkips);
                                $skip = '';
                                if (isset($getSkips) && $getSkips != '' && $cntSkip >= 1) {
                                    foreach ($getSkips as $skips_key => $skips_value) {
                                        $skpVar = (isset($skips_value->skip_var) && $skips_value->skip_var != '' ? $skips_value->skip_var : '');
                                        $skpVal = (isset($skips_value->skip_value) && $skips_value->skip_value != '' ? $skips_value->skip_value : '');
                                        $skpGate = (isset($skips_value->skip_gate) && $skips_value->skip_gate != '' ? $skips_value->skip_gate : '');
                                        if ($skips_key == 0) {
                                            $skip .= strtolower($skpVar) . '=' . $skpVal;
                                        } else {
                                            if ($skpGate == 'AND') {
                                                $skip .= ' AND ' . strtolower($skpVar) . '=' . $skpVal;
                                            } elseif ($skpGate == 'OR') {
                                                $skip .= ' OR ' . strtolower($skpVar) . '=' . $skpVal;
                                            }
                                        }
                                    }
                                }elseif (isset($valueSectionDetail->skipQuestion) && $valueSectionDetail->skipQuestion != ''){
                                    $skip=$valueSectionDetail->skipQuestion;
                                }

                                $td1 = '';
                                $td2 = '';
                                $td3 = '';
                                $td4= '';
                                $l1sec = '';
                                $l2sec = '';
                                $l3sec = '';
                                $l4sec = '';
                                $l5sec = '';
                                $ol1sec = '';
                                $ol2sec = '';
                                $ol3sec = '';
                                $ol4sec = '';
                                $ol5sec = '';
                                if ($displaylanguagel1 == 'on') {
                                    $l1sec = htmlspecialchars($valueSectionDetail->label_l1);
                                }
                                if (isset($valueSectionDetail->label_l2) && $valueSectionDetail->label_l2 != '' &&
                                    $displaylanguagel2 == 'on') {
                                    $l2sec = ' <br> ' . htmlspecialchars($valueSectionDetail->label_l2);
                                }
                                if (isset($valueSectionDetail->label_l3) && $valueSectionDetail->label_l3 != '' &&
                                    $displaylanguagel3 == 'on') {
                                    $l3sec = ' <br> ' . htmlspecialchars($valueSectionDetail->label_l3);
                                }
                                if (isset($valueSectionDetail->label_l4) && $valueSectionDetail->label_l4 != '' &&
                                    $displaylanguagel4 == 'on') {
                                    $l4sec = ' <br> ' . htmlspecialchars($valueSectionDetail->label_l4);
                                }
                                if (isset($valueSectionDetail->label_l5) && $valueSectionDetail->label_l5 != '' &&
                                    $displaylanguagel5 == 'on') {
                                    $l5sec = ' <br> ' . htmlspecialchars($valueSectionDetail->label_l5);
                                }


                                $td2=$l1sec .  $l2sec .  $l3sec .   $l4sec .  $l5sec  ;
                                $insts = '';
                                $isnt = 0;
                                if (isset($valueSectionDetail->instruction_l1) && $valueSectionDetail->instruction_l1 != '' &&
                                    $displaylanguagel1 == 'on') {
                                    $isnt = 1;
                                    $insts .= '<span>Instructions: ' . $valueSectionDetail->variable_name . ': </span><small>' . htmlspecialchars($valueSectionDetail->instruction_l1) . '</small>';
                                }
                                if (isset($valueSectionDetail->instruction_l2) && $valueSectionDetail->instruction_l2 != '' &&
                                    $displaylanguagel2 == 'on') {
                                    $isnt = 1;
                                    $insts .= '<br><span>' . htmlspecialchars($valueSectionDetail->instruction_l2) . '</span> ';
                                }
                                if (isset($valueSectionDetail->instruction_l3) && $valueSectionDetail->instruction_l3 != '' &&
                                    $displaylanguagel3 == 'on') {
                                    $isnt = 1;
                                    $insts .= '<br><span>' . htmlspecialchars($valueSectionDetail->instruction_l3) . '</span> ';
                                }
                                if (isset($valueSectionDetail->instruction_l4) && $valueSectionDetail->instruction_l4 != '' &&
                                    $displaylanguagel4 == 'on') {
                                    $isnt = 1;
                                    $insts .= '<br><span>' . htmlspecialchars($valueSectionDetail->instruction_l4) . '</span> ';
                                }
                                if (isset($valueSectionDetail->instruction_l5) && $valueSectionDetail->instruction_l5 != '' &&
                                    $displaylanguagel5 == 'on') {
                                    $isnt = 1;
                                    $insts .= ' <br><span>' . htmlspecialchars($valueSectionDetail->instruction_l5) . '</span> ';
                                }
                                if ($isnt == 1) {
                                    $td2 .= '<br><br><br><br><br><br><span colspan="4" style="color: red; font-size: 11px" >{' . $insts . '}</span>';
                                }

                                if (isset($valueSectionDetail->myrow_options) && $valueSectionDetail->myrow_options != '') {
                                    $td3 .= ' <table    cellpadding="2" cellspacing="0"> ';

                                    foreach ($valueSectionDetail->myrow_options as $okey => $oval) {
                                        if ($displaylanguagel1 == 'on') {
                                            $ol1sec = htmlspecialchars($oval->label_l1);
                                        }
                                        if (isset($oval->label_l2) && $oval->label_l2 != '' &&
                                            $displaylanguagel2 == 'on') {
                                            $ol2sec = ' <br>' . htmlspecialchars($oval->label_l2);
                                        }
                                        if (isset($oval->label_l3) && $oval->label_l3 != '' &&
                                            $displaylanguagel3 == 'on') {
                                            $ol3sec = ' <br>' . htmlspecialchars($oval->label_l3);
                                        }
                                        if (isset($oval->label_l4) && $oval->label_l4 != '' &&
                                            $displaylanguagel4 == 'on') {
                                            $ol4sec = ' <br>' . htmlspecialchars($oval->label_l4);
                                        }
                                        if (isset($oval->label_l5) && $oval->label_l5 != '' &&
                                            $displaylanguagel5 == 'on') {
                                            $ol5sec = ' <br>' . htmlspecialchars($oval->label_l5);
                                        }

                                        $olinsts = '';
                                        $olisnt = 0;
                                        if (isset($oval->instruction_l1) && $oval->instruction_l1 != '' &&
                                            $displaylanguagel1 == 'on') {
                                            $olisnt = 1;
                                            $olinsts .= '<small>Instructions: ' . $oval->variable_name . ': </small><strong>' . htmlspecialchars($oval->instruction_l1) . '</strong>';
                                        }
                                        if (isset($oval->instruction_l2) && $oval->instruction_l2 != '' &&
                                            $displaylanguagel2 == 'on') {
                                            $olisnt = 1;
                                            $olinsts .= '<br><strong>' . htmlspecialchars($oval->instruction_l2) . '</strong> ';
                                        }
                                        if ($olisnt == 1) {
                                            $td2 .= '<br><br><span colspan="4" style="color: red; font-size: 11px" >{' . $olinsts . '}</span>';
                                        }

                                        $td3 .= ' <tr>';
                                        $td3 .= "<td width=\"65%\"><br><span><span><small><strong>" . strtolower($oval->variable_name) . ": </strong></small> " . $ol1sec . " 
                                             " . $ol2sec . " 
                                             " . $ol3sec . " 
                                             " . $ol4sec . "
                                             " . $ol5sec . "  
                                              </span> </span>
                                             </td>";
                                        $td3 .= ' <td width="15%"> ' . $oval->option_value . '</td> ';
                                        $optionsubhtml_Min = '';
                                        $optionsubhtml_max = '';
                                        if ($oval->nature == 'Input-Numeric') {
                                            if (isset($oval->MinVal) && $oval->MinVal != '') {
                                                $optionsubhtml_Min = ' <p class="myborder"><small> Min: </small>' . htmlspecialchars($oval->MinVal).'</p>';
                                            } else {
                                                $optionsubhtml_Min = '<p class="myborder"><small style="color: red">Min: ERROR</small></p>';
                                            }
                                        } else {
                                            if (isset($oval->MinVal) && $oval->MinVal != '') {
                                                $optionsubhtml_Min = '<p class="myborder"><small> Min: </small>' . htmlspecialchars($oval->MinVal).'</p>';
                                            }
                                        }
                                        if ($oval->nature == 'Input-Numeric') {
                                            if (isset($oval->MaxVal) && $oval->MaxVal != '') {
                                                $optionsubhtml_max .= '<p class="myborder"><small>Max: </small>' . htmlspecialchars($oval->MaxVal).'</p>';
                                            } else {
                                                $optionsubhtml_max .= '<p class="myborder"><small>Max: </small><small  style="color: red">, Max: ERROR</small></p>';
                                            }
                                        } else {
                                            if (isset($oval->MaxVal) && $oval->MaxVal != '') {
                                                $optionsubhtml_max = '<p class="myborder"><small>Max: </small>' . htmlspecialchars($oval->MaxVal).'</p>';
                                            }
                                        }


                                        $td3 .= '<td width="20%">' . (isset($oval->nature) && $oval->nature ?
                                                '<small>' . $oval->nature . ' </small> ' : '')
                                            . $optionsubhtml_Min . $optionsubhtml_max
                                            . ' </td> ';
                                        $skip.=(isset($oval->skipQuestion) && $oval->skipQuestion ?$oval->skipQuestion : '');
                                        $td3 .= '</tr> ';
                                        if (isset($oval->otherOptions) && $oval->otherOptions != '') {
                                            $td3 .= ' <tr><td colspan="3"><ul> ';
                                            foreach ($oval->otherOptions as $ok => $ov) {
                                                $td3 .= '<li><small><strong> ' . $ov->variable_name . '</strong></small> --' . $ov->label_l1 . ' --' . $ov->option_value . '</li> ';
                                            }
                                            $td3 .= '</ul></td></tr> ';
                                        }
                                    }
                                    $td3 .= '</table> ';
                                }

                                if (isset($skip) && $skip != '') {
                                    $td4 .= ' <small style="color: blue;background-color: lightgrey"> Skip: </small><span style="color: blue;background-color: lightgrey;border: 1px solid red; font-size: 11px"> ' . htmlspecialchars($skip) . '</span><br> ';
                                }
                                $html_Min = '<p class="myborder"> <small  style="color: red; font-size: 11px">Min: ERROR</small></p>';
                                $html_max = '<p class="myborder"> <small  style="color: red; font-size: 11px">, Max: ERROR</small></p>';

                                if ($valueSectionDetail->nature == 'Input-Numeric') {
                                    if (isset($valueSectionDetail->MinVal) && $valueSectionDetail->MinVal != '') {
                                        $td4 .= '<p class="myborder"><small> Min: </small>' . $valueSectionDetail->MinVal.'</p>';
                                    } else {
                                        $td4 .= $html_Min;
                                    }
                                } else {
                                    if (isset($valueSectionDetail->MinVal) && $valueSectionDetail->MinVal != '') {
                                        $td4 .= '<p class="myborder"><small> Min: </small>' . $valueSectionDetail->MinVal.'</p>';
                                    }
                                }
                                if ($valueSectionDetail->nature == 'Input-Numeric') {
                                    if (isset($valueSectionDetail->MaxVal) && $valueSectionDetail->MaxVal != '') {
                                        $td4 .= '<p class="myborder"><small> Max: </small>' . $valueSectionDetail->MaxVal.'</p>';
                                    } else {
                                        $td4 .= $html_max;
                                    }
                                } else {
                                    if (isset($valueSectionDetail->MaxVal) && $valueSectionDetail->MaxVal != '') {
                                        $td4 .= '<p class="myborder"><small> Max: </small>' . $valueSectionDetail->MaxVal.'</p>';
                                    }
                                }


                                $optionsubhtml .= '<tr>';
                                $optionsubhtml .='<td  width="12%"  align="center"><strong> ' . strtolower($valueSectionDetail->variable_name) . '</strong><br>
                                        <small> ' . $valueSectionDetail->nature . '</small></td>';
                                $optionsubhtml .='<td width="45%">' . $td2 . '</td> ';
                                $optionsubhtml .='<td width="36%">' . $td3 . '</td> ';
                                $optionsubhtml .='<td width="7%"  align="center">' . $td4 . '</td> ';
                                $optionsubhtml .= '  </tr> ';

                            }
                        }
                        $optionsubhtml .= "</table>";
                        $pdf->AddPage();

                        $pdf->writeHTML($optionsubhtml, true, false, false, false, '');
                    }
                }
            }


            $bMargin = $pdf->getBreakMargin();
            $auto_page_break = $pdf->getAutoPageBreak();
            $pdf->SetAutoPageBreak(true, 0);
            $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
            $pdf->setPageMark();
            ob_end_clean();
            $pdf->Output('dictionary.pdf', 'I');
        } else {
            echo 'Invalid Project, Please select project';
        }
    }

    function getStings()
    {
        ob_end_clean();
        $flag = 0;
        $MSection = new MSection();
        $searchData = array();
        $searchData['idProjects'] = $_REQUEST['project'];
        $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
        $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
        $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
        $searchData['includeTitle'] = 'Y';
        $searchData['orderby'] = 'idSection';
        if (isset($_REQUEST['language']) && $_REQUEST['language'] != '' && $_REQUEST['language'] != '0') {
            $lang = 'label_' . $_REQUEST['language'];
        } else {
            $lang = 'label_l1';
        }
        $fileEngSting = '';

        if ($lang == 'label_l1') {
            $fileEngSting .= '<string name="app_name">  </string>
<string name="btnSync">Download Data</string>
<string name="btnUpload">Upload Data</string>
<string name="prompt_email">Email</string>
<string name="prompt_password">Password</string>
<string name="action_sign_in">Login</string>
<string name="action_sign_in_short">Sign in</string>
<string name="splashText"> </string>
<string name="splashText2">  </string>
<string name="check_pending_forms">CHECK PENDING FORMS</string>
<string name="open_new_form">OPEN NEW FORM</string>
<string name="records_summary">Records Summary</string>
<string name="main_menu">Main Menu</string>
<string name="only_for_testing">ONLY FOR TESTING</string>
<string name="database">Database</string>
<string name="no"> No </string>
<string name="dkn"> Don’t Know </string>
<string name="none"> No one </string>
<string name="never"> Never</string>
<string name="na"> Applicable /Not Available  </string>
<string name="nap"> Not Applicable </string>
<string name="error_invalid_password">This password is too short</string>
<string name="error_field_required">This field is required</string>
<string name="error_incorrect_password">This password is incorrect</string>
<string name="nav">Not Available </string>
<string name="ref"> Refused </string>
<string name="other"> Other </string>
<string name="specify"> Please explain </string>
<string name="year"> Year </string>
<string name="month"> Month </string>
<string name="weeks"> Week </string>
<string name="days"> Day </string>
<string name="hours"> Hour </string>
<string name="minutes"> Minutes </string>
<string name="kg"> Kilograms </string>
<string name="km"> Kilometers </string>
<string name="cm"> cm </string>
<string name="in"> Inch </string>
<string name="rupees">  Rupees </string>
<string name="num"> Number </string>
<string name="name"> Name </string>
<string name="contactnum">Contact Number </string>
<string name="checkHHpresent"> The name of head of the household corresponds to the line listing data.</string>
<string name="newHHheadname"> Name of new head of the household </string>' . "\n";
        } elseif ($lang == 'label_l2') {
            $fileEngSting .= '<string name="app_name">  </string>
<string name="btnSync">Download Data</string>
<string name="btnUpload">Upload Data</string>
<string name="prompt_email">Email</string>
<string name="prompt_password">Password</string>
<string name="action_sign_in">Login</string>
<string name="action_sign_in_short">Sign in</string>
<string name="splashText"> </string>
<string name="splashText2">  </string>
<string name="check_pending_forms">CHECK PENDING FORMS</string>
<string name="open_new_form">OPEN NEW FORM</string>
<string name="records_summary">Records Summary</string>
<string name="main_menu">Main Menu</string>
<string name="only_for_testing">ONLY FOR TESTING</string>
<string name="database">Database</string>
<string name="error_invalid_password">This password is too short</string>
<string name="error_field_required">This field is required</string>
<string name="error_incorrect_password">This password is incorrect</string>
<string name="no"> نہیں </string>
<string name="dkn"> معلوم نہیں </string>
<string name="none"> کوئی نہیں </string>
<string name="never"> کبھی نہیں </string>
<string name="na"> قابل اطلاق / دستیاب نہیں  </string>
<string name="nap"> قابل اطلاق نہیں </string>
<string name="nav"> دستیاب نہیں </string>
<string name="ref"> انکار کر دیا </string>
<string name="other"> دیگر </string>
<string name="specify"> وضاحت کریں </string>
<string name="year"> سال </string>
<string name="month"> مہینہ </string>
<string name="weeks"> ہفتے </string>
<string name="days"> دن </string>
<string name="hours"> گھنٹے </string>
<string name="minutes"> منٹ </string>
<string name="kg"> کلوگرام </string>
<string name="km"> کلومیٹر </string>
<string name="cm"> سینٹی میٹر </string>
<string name="in"> انچ </string>
<string name="rupees"> روپے </string>
<string name="num"> اعداد </string>
<string name="name"> نام </string>
<string name="contactnum"> رابطہ نمبر </string>
<string name="checkHHpresent"> گھر کے سربراہ کا نام لائن لسٹنگ ڈیٹا سے مطابقت رکھتا ہے۔ </string>
<string name="newHHheadname"> نیا سربراہ کا نام </string>' . "\n";
        } else {
            $fileEngSting .= '';
        }
        $result = $MSection->getAllData($searchData);
        $secHead = array();
        foreach ($result as $key => $value) {
            $secHead[$value->idSection] = array(
                'title_l1' => $value->section_title_l1,
                'desc_l1' => $value->section_desc_l1,
                'title_l2' => $value->section_title_l2,
                'desc_l2' => $value->section_desc_l2,
                'title_l3' => $value->section_title_l3,
                'desc_l3' => $value->section_desc_l3,
                'title_l4' => $value->section_title_l4,
                'desc_l4' => $value->section_desc_l4,
                'title_l5' => $value->section_title_l5,
                'desc_l5' => $value->section_desc_l5
            );
            $fileEngSting .= '<string name="' . strtolower($value->variable_name) . '">' . htmlspecialchars($value->$lang) . '</string>' . "\n";
            /*if (isset($value->instruction_l1) && $value->instruction_l1 != '' && $lang == 'label_l1') {
                $fileEngSting .= '<string name="' . strtolower($value->variable_name) . '_info">' . htmlspecialchars($value->instruction_l1) . '</string>' . "\n";
            }
            if (isset($value->instruction_l2) && $value->instruction_l2 != '' && $lang == 'label_l2') {
                $fileEngSting .= '<string name="' . strtolower($value->variable_name) . '_info">' . htmlspecialchars($value->instruction_l2) . '</string>' . "\n";
            }
            if (isset($value->instruction_l3) && $value->instruction_l3 != '' && $lang == 'label_l3') {
                $fileEngSting .= '<string name="' . strtolower($value->variable_name) . '_info">' . htmlspecialchars($value->instruction_l3) . '</string>' . "\n";
            }
            if (isset($value->instruction_l4) && $value->instruction_l4 != '' && $lang == 'label_l4') {
                $fileEngSting .= '<string name="' . strtolower($value->variable_name) . '_info">' . htmlspecialchars($value->instruction_l4) . '</string>' . "\n";
            }
            if (isset($value->instruction_l5) && $value->instruction_l5 != '' && $lang == 'label_l5') {
                $fileEngSting .= '<string name="' . strtolower($value->variable_name) . '_info">' . htmlspecialchars($value->instruction_l5) . '</string>' . "\n";
            }*/
        }

        $fileHeadSting = '';
        foreach ($secHead as $k => $sH) {
            if ($lang == 'label_l1') {
                $fileHeadSting .= '<string name="' . strtolower($this->clean($sH['title_l1'])) . '_mainheading">' . htmlspecialchars($sH['title_l1']) . ': ' . htmlspecialchars(str_replace('-', '', $sH['desc_l1'])) . '</string>' . "\n";
            } elseif ($lang == 'label_l2') {
                $fileHeadSting .= '<string name="' . strtolower($this->clean($sH['title_l1'])) . '_mainheading">' . htmlspecialchars($sH['title_l2']) . ': ' . htmlspecialchars($sH['desc_l2']) . '</string>' . "\n";
            } elseif ($lang == 'label_l3') {
                $fileHeadSting .= '<string name="' . strtolower($this->clean($sH['title_l1'])) . '_mainheading">' . htmlspecialchars($sH['title_l3']) . ': ' . htmlspecialchars($sH['desc_l3']) . '</string>' . "\n";
            } elseif ($lang == 'label_l4') {
                $fileHeadSting .= '<string name="' . strtolower($this->clean($sH['title_l1'])) . '_mainheading">' . htmlspecialchars($sH['title_l4']) . ': ' . htmlspecialchars($sH['desc_l4']) . '</string>' . "\n";
            } elseif ($lang == 'label_l5') {
                $fileHeadSting .= '<string name="' . strtolower($this->clean($sH['title_l1'])) . '_mainheading">' . htmlspecialchars($sH['title_l5']) . ': ' . htmlspecialchars($sH['desc_l5']) . '</string>' . "\n";
            }
        }
        $renderFile = $fileHeadSting . $fileEngSting;
        if ($flag == 0) {
            $file = 'assets/uploads/myfiles/' . $lang . "sting.xml";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $renderFile);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/xml");
            readfile($file);
        } else {
            echo 'Invalid Data, Please provide proper details';
        }
    }

    function clean($string)
    {
        $string = str_replace(' ', '', $string);
        $string = str_replace('-', '', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    function getDCF()
    {
        ob_end_clean();
        $flag = 0;
        $MSection = new MSection();
        $searchData = array();
        $searchData['idProjects'] = $_REQUEST['project'];
        $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
        $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
        $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
        $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
        $searchData['orderby'] = 'idSection';
        if (isset($_REQUEST['language']) && $_REQUEST['language'] != '' && $_REQUEST['language'] != '0') {
            $lang = 'label_' . $_REQUEST['language'];
        } else {
            $lang = '';
        }

        $result = $MSection->getAllData($searchData);

        $projectName = $result[0]->project_name;

        $fileEngSting = '
            [Dictionary]
            Version=CSPro 7.4
            Label=' . $projectName . '
            Name=' . $projectName . '
            RecordTypeStart=1
            RecordTypeLen=1
            Positions=Relative
            ZeroFill=No
            DecimalChar=Yes
            SecurityOptions=4FDC6D1E5AA972FD3858B5064FBFCD16A5D14508F2F8BA5C6EB018E2C77D25FA
            
            [Languages]
            EN=English
            UR=Urdu
            
            [Level]
            Label=' . $projectName . ' 
            Name=' . $projectName . '
            
            [IdItems]
            
            [Item]
            Label=coe_covid_sero Identification
            Name=COE_COVID_SERO_ID
            Start=2
            Len=1
            
            [Record]
            Label=COE_COVID_SERO_HH|COE_COVID_SERO_HH
            Name=COE_COVID_SERO_HH
            RecordTypeValue="1"
            RecordLen=308
            
            ' . "\n";

        foreach ($result as $key => $value) {
            $fileEngSting .= '
            [Item]
                Label=' . htmlspecialchars($value->label_l1) . '|' . htmlspecialchars($value->label_l2) . '
                Name=' . strtolower($value->variable_name) . '
                Start=' . $value->MinVal . '
                Len=' . $value->MaxVal . '
                DataType=' . $value->nature . "\n";
        }
        if ($flag == 0) {
            $file = 'assets/uploads/myfiles/my_dcf.dcf';
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileEngSting);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: plain/text");
            readfile($file);
        } else {
            echo 'Invalid Data, Please provide proper details';
        }
    }

    function questionArr($dataarr)
    {
        $myresult = array();
        foreach ($dataarr as $key => $value) {
            if (isset($value->idParentQuestion) && $value->idParentQuestion != '' && array_key_exists(strtolower($value->idParentQuestion), $myresult)) {
                $mykey = strtolower($value->idParentQuestion);
                $myresult[strtolower($mykey)]->myrow_options[] = $value;
            } else {
                $mykey = strtolower($value->variable_name);
                $myresult[strtolower($mykey)] = $value;
            }
        }
        $data = array();
        foreach ($myresult as $val) {
            $data[] = $val;
        }
        return $data;
    }

    function getXmlQuestions()
    {
        if (isset($_REQUEST['project']) && $_REQUEST['project'] != '' && $_REQUEST['project'] != 0) {
            // $this->load->library('excel');
            $idProject = $_REQUEST['project'];
            $this->load->model('mmodule');
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $idProject;
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getXmlQuestionsData($searchData);
            $data = $this->questionArr($result);
            $xml = '';
            foreach ($data as $list) {
                $xml .= "<string name='Q_" . strtolower($list->variable_name) . "'>" . strtolower($list->variable_name) . "</string> \n";
            }
            $file = "assets/uploads/myfiles/myXmlQuesitons.xml";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $xml);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/xml");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select project';
        }
    }

    function getContractsData()
    {
        ob_end_clean();
        $MSection = new MSection();
        $searchData = array();
        $searchData['idProjects'] = $_REQUEST['project'];
        $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
        $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
        $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
        $searchData['includeTitle'] = 'Y';
        $searchData['orderby'] = 'idSection';
        $fileEngSting = '';
        $data = $MSection->getAllData($searchData);
        $result = $this->questionArr($data);
        foreach ($result as $key => $value) {
            if ($value->nature != 'Title') {
                $fileEngSting .= 'public String ' . strtolower($value->variable_name) . ';' . "\n";
            }
            if (isset($value->myrow_options)) {
                foreach ($value->myrow_options as $options) {
                    if ($value->nature == 'Radio' && ($options->nature == 'Input' || $options->nature == 'Input-Numeric')) {
                        $fileEngSting .= 'public String ' . strtolower($options->variable_name) . 'x;' . "\n";
                    } elseif ($value->nature == 'CheckBox' && ($options->nature == 'Input' || $options->nature == 'Input-Numeric')) {
                        $fileEngSting .= 'public String ' . strtolower($options->variable_name) . ';' . "\n";
                        $fileEngSting .= 'public String ' . strtolower($options->variable_name) . 'x;' . "\n";
                    } elseif ($options->nature == 'CheckBox') {
                        $fileEngSting .= 'public String ' . strtolower($options->variable_name) . ';' . "\n";
                    } elseif ($options->nature == 'Input' || $options->nature == 'Input-Numeric') {
                        $fileEngSting .= 'public String ' . strtolower($options->variable_name) . ';' . "\n";
                    }

                }
            }

        }
        $file = 'assets/uploads/myfiles/contract.txt';
        $txt = fopen($file, "w") or die("Unable to open file!");
        fwrite($txt, $fileEngSting);
        fclose($txt);
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: plain/text");
        readfile($file);
    }

    function getSaveDraftData()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $fileData = 'JSONObject json = new JSONObject(); ' . "\n";
            foreach ($data as $key => $value) {
                $fileOtherData = '';
                $question_type = $value->nature;
                if ($question_type == 'Input-Numeric') {
                    $fileData .= 'json.put("' . strtolower($value->variable_name) . '", bi.' . strtolower($value->variable_name) . '.getText().toString());' . "\n\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            } elseif ($options->nature == 'Input') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            } elseif ($options->nature == 'Title') {
//                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Input') {
                    $fileData .= 'json.put("' . strtolower($value->variable_name) . '", bi.' . strtolower($value->variable_name) . '.getText().toString());' . "\n\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            } elseif ($options->nature == 'Input') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            } elseif ($options->nature == 'Title') {
//                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Title') {
//                    $fileData .= 'json.put("' . strtolower($value->variable_name) . '", bi.' . strtolower($value->variable_name) . '.getText().toString());' . "\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n\n";
                            } elseif ($options->nature == 'Input') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n\n";
                            } elseif ($options->nature == 'Title') {
//                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Radio') {
                    $fileData .= 'json.put("' . strtolower($value->variable_name) . '", ';
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileData .= '';
                            } else {
                                $fileData .= 'bi.' . strtolower($options->variable_name) . '.isChecked() ? "' . $options->option_value . '" ' . "\n" . ' : ';
                            }
                            if ($options->nature == 'Input-Numeric') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . 'x", bi.' . strtolower($options->variable_name) . 'x.getText().toString());' . "\n";
                            } elseif ($options->nature == 'Input') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . 'x", bi.' . strtolower($options->variable_name) . 'x.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= ' "-1"); ' . "\n\n";
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'CheckBox') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '",bi.' . strtolower($options->variable_name) . '.isChecked() ? "' . $options->option_value . '" :"-1");' . "\n\n";
                            if ($options->nature == 'Input-Numeric') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . 'x", bi.' . strtolower($options->variable_name) . 'x.getText().toString());' . "\n";
                            } elseif ($options->nature == 'Input') {
                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . 'x", bi.' . strtolower($options->variable_name) . 'x.getText().toString());' . "\n";
                            } elseif ($options->nature == 'Title') {
//                                $fileOtherData .= 'json.put("' . strtolower($options->variable_name) . '", bi.' . $options->variable_name . '.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                }
            }
            $file = "assets/uploads/myfiles/savedraft.java";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileData);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/plain");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select project';
        }
    }

    function getNewSaveDraft()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $fileData = ' ' . "\n";
            foreach ($data as $key => $value) {
                $fileOtherData = '';
                $question_type = $value->nature;
                if ($question_type == 'Input-Numeric' || $question_type == 'Input') {
                    $fileData .= 'form.set' . ucfirst(strtolower($value->variable_name)) . '(bi.' . strtolower($value->variable_name) . '.getText().toString());' . "\n\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'form.set' . ucfirst(strtolower($options->variable_name)) . '(bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Title') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'form.set' . ucfirst(strtolower($options->variable_name)) . '(bi.' . strtolower($options->variable_name) . '.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Radio') {
                    $fileData .= 'form.set' . ucfirst(strtolower($value->variable_name)) . '( ';
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileData .= '';
                            } else {
                                $fileData .= 'bi.' . strtolower($options->variable_name) . '.isChecked() ? "' . $options->option_value . '" ' . "\n" . ' : ';
                            }
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'form.set' . ucfirst(strtolower($options->variable_name)) . 'x(bi.' . strtolower($options->variable_name) . 'x.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= ' "-1"); ' . "\n\n";
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'CheckBox') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileOtherData .= '';
                            } else {
                                $fileOtherData .= 'form.set' . ucfirst(strtolower($options->variable_name)) . '(bi.' . strtolower($options->variable_name) . '.isChecked() ? "' . $options->option_value . '" : "-1");' . "\n\n";
                            }


                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'form.set' . ucfirst(strtolower($options->variable_name)) . 'x(bi.' . strtolower($options->variable_name) . 'x.getText().toString());' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                }
            }
            $file = "assets/uploads/myfiles/newsavedraft.java";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileData);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/plain");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select project';
        }
    }

    function toString_()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $fileData = ' ' . "\n";
            foreach ($data as $key => $value) {
                $fileOtherData = '';
//                .put("s1q9", s1q9 == null ? "" : s1q9)
                $question_type = $value->nature;
                $ques = strtolower($value->variable_name) . ' == null ? "" :' . strtolower($value->variable_name);
                if ($question_type == 'Input-Numeric' || $question_type == 'Input') {
                    $fileData .= '.put("' . strtolower($value->variable_name) . '", ' . $ques . ')' . "\n\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $quesX = strtolower($options->variable_name) . ' == null ? "" :' . strtolower($options->variable_name);
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . '", ' . $quesX . ')' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Title') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $quesX = strtolower($options->variable_name) . ' == null ? "" :' . strtolower($options->variable_name);
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . '", ' . $quesX . ')' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Radio') {
                    $fileData .= '.put("' . strtolower($value->variable_name) . '", ' . $ques . ')' . "\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $quesX = strtolower($options->variable_name . 'x') . ' == null ? "" :' . strtolower($options->variable_name . 'x');
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . 'x", ' . $quesX . ')' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'CheckBox') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileOtherData .= '';
                            } else {
                                $quesO = strtolower($options->variable_name) . ' == null ? "" :' . strtolower($options->variable_name);
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . '", ' . $quesO . ')' . "\n\n";
                            }


                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $quesX = strtolower($options->variable_name . 'x') . ' == null ? "" :' . strtolower($options->variable_name . 'x');
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . 'x", ' . $quesX . ')' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                }
            }
            $file = "assets/uploads/myfiles/toString.txt";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileData);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/plain");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select Section';
        }
    }

    function toString()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $fileData = ' ' . "\n";
            foreach ($data as $key => $value) {
                $fileOtherData = '';
//                .put("s1q9", s1q9 == null ? "" : s1q9)
                $question_type = $value->nature;
                if ($question_type == 'Input-Numeric' || $question_type == 'Input') {
                    $fileData .= '.put("' . strtolower($value->variable_name) . '", ' . strtolower($value->variable_name) . ')' . "\n\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . '", ' . strtolower($options->variable_name) . ')' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Title') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . '", ' . strtolower($options->variable_name) . ')' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Radio') {
                    $fileData .= '.put("' . strtolower($value->variable_name) . '", ' . strtolower($value->variable_name) . ')' . "\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . 'x", ' . strtolower($options->variable_name) . 'x)' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'CheckBox') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileOtherData .= '';
                            } else {
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . '", ' . strtolower($options->variable_name) . ')' . "\n\n";
                            }


                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= '.put("' . strtolower($options->variable_name) . 'x", ' . strtolower($options->variable_name) . 'x)' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                }
            }
            $file = "assets/uploads/myfiles/toString.txt";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileData);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/plain");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select Section';
        }
    }

    function getJSON()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $fileData2 = json_encode($data);
            $file = "assets/uploads/myfiles/json.txt";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileData2);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/plain");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select Section';
        }
    }

    function hydrate2_old()
    {
        ob_end_clean();
        if (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $fileData = ' ' . "\n";
            foreach ($data as $key => $value) {
                $fileOtherData = '';
                $question_type = $value->nature;
                if ($question_type == 'Input-Numeric' || $question_type == 'Input') {
                    $fileData .= 'this.' . strtolower($value->variable_name) . ' = json.getString("' . strtolower($value->variable_name) . '");​' . "\n\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Title') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Radio') {
                    $fileData .= 'this.' . strtolower($value->variable_name) . ' = json.getString("' . strtolower($value->variable_name) . '");​' . "\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileData .= '';
                            } else {
                                $fileData .= '';
//                                $fileData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\n";
                            }
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . 'x = json.getString("' . strtolower($options->variable_name) . 'x");​' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'CheckBox') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            $fileOtherData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\n\n";
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . 'x = json.getString("' . strtolower($options->variable_name) . 'x");​' . "\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                }
            }
            $file = "assets/uploads/myfiles/hyderate.txt";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileData);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/plain");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select Section';
        }
    }

    function hydrateJson()
    {
        ob_end_clean();
        if (isset($_REQUEST['project']) && $_REQUEST['project'] != '' && $_REQUEST['project'] != 0) {
            $this->load->model('msection');
            $MSection = new MSection();
            /*$searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);*/

            $searchData = array();
            $searchData['idProjects'] = $_REQUEST['project'];
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $searchData['includeTitle'] = 'Y';
            $searchData['orderby'] = 'idSection';

            $result = $MSection->getAllData($searchData);
            $data = $this->questionArr($result);


            $fileData = ' ' . "\r\n";
            foreach ($data as $key => $value) {
                $fileOtherData = '';
                $question_type = $value->nature;
                if ($question_type == 'Input-Numeric' || $question_type == 'Input') {
                    $fileData .= 'this.' . strtolower($value->variable_name) . ' = json.getString("' . strtolower($value->variable_name) . '");​' . "\r\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\r\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Title') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\r\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'Radio') {
                    $fileData .= 'this.' . strtolower($value->variable_name) . ' = json.getString("' . strtolower($value->variable_name) . '");​' . "\r\n";
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileData .= '';
                            } else {
                                $fileData .= '';
//                                $fileData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\r\n";
                            }
                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . 'x = json.getString("' . strtolower($options->variable_name) . 'x");​' . "\r\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                } elseif ($question_type == 'CheckBox') {
                    if (isset($value->myrow_options) && $value->myrow_options != '') {
                        foreach ($value->myrow_options as $options) {
                            if ($options->nature == 'Title') {
                                $fileOtherData .= '';
                            } else {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . ' = json.getString("' . strtolower($options->variable_name) . '");​' . "\r\n";
                            }

                            if ($options->nature == 'Input-Numeric' || $options->nature == 'Input') {
                                $fileOtherData .= 'this.' . strtolower($options->variable_name) . 'x = json.getString("' . strtolower($options->variable_name) . 'x");​' . "\r\n";
                            }
                        }
                    }
                    $fileData .= $fileOtherData;
                }
            }
            $file = "assets/uploads/myfiles/hyderate.txt";
            $txt = fopen($file, "w") or die("Unable to open file!");
            fwrite($txt, $fileData);
            fclose($txt);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header("Content-Type: text/plain");
            readfile($file);
        } else {
            echo 'Invalid Project, Please select Section';
        }
    }

    function hydrateModel()
    {
        ob_end_clean();
        $MSection = new MSection();
        $searchData = array();
        $searchData['idProjects'] = $_REQUEST['project'];
        $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
        $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
        $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
        $searchData['includeTitle'] = 'Y';
        $searchData['orderby'] = 'idSection';
        $fileEngSting = '';
        $data = $MSection->getAllData($searchData);
        $result = $this->questionArr($data);
        foreach ($result as $key => $value) {
            if ($value->nature != 'Title') {
                $fileEngSting .= 'this.' . strtolower($value->variable_name) . '=cursor.getString(cursor.getColumnIndex(FormsTable.COLUMN_' . strtoupper($value->variable_name) . '));' . "\r\n";
            }
            if (isset($value->myrow_options)) {
                foreach ($value->myrow_options as $options) {
                    if ($value->nature == 'Radio' && ($options->nature == 'Input' || $options->nature == 'Input-Numeric')) {
                        $fileEngSting .= 'this.' . strtolower($options->variable_name) . 'x=cursor.getString(cursor.getColumnIndex(FormsTable.COLUMN_' . strtoupper($options->variable_name) . 'x));' . "\r\n";
                    } elseif ($value->nature == 'CheckBox' && ($options->nature == 'Input' || $options->nature == 'Input-Numeric')) {
                        $fileEngSting .= 'this.' . strtolower($options->variable_name) . '=cursor.getString(cursor.getColumnIndex(FormsTable.COLUMN_' . strtoupper($options->variable_name) . '));' . "\r\n";
                        $fileEngSting .= 'this.' . strtolower($options->variable_name) . 'x=cursor.getString(cursor.getColumnIndex(FormsTable.COLUMN_' . strtoupper($options->variable_name) . 'x));' . "\r\n";
                    } elseif ($options->nature == 'CheckBox') {
                        $fileEngSting .= 'this.' . strtolower($options->variable_name) . '=cursor.getString(cursor.getColumnIndex(FormsTable.COLUMN_' . strtoupper($options->variable_name) . '));' . "\r\n";
                    } elseif ($options->nature == 'Input' || $options->nature == 'Input-Numeric') {
                        $fileEngSting .= 'this.' . strtolower($options->variable_name) . '=cursor.getString(cursor.getColumnIndex(FormsTable.COLUMN_' . strtoupper($options->variable_name) . '));' . "\r\n";
                    }

                }
            }
        }
        $file = 'assets/uploads/myfiles/hydrateModel.txt';
        $txt = fopen($file, "w") or die("Unable to open file!");
        fwrite($txt, $fileEngSting);
        fclose($txt);
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: plain/text");
        readfile($file);
    }

    function getCodeBook()
    {
        if (isset($_REQUEST['project']) && $_REQUEST['project'] != '' && $_REQUEST['project'] != 0) {
            // $this->load->library('excel');
            $idProject = $_REQUEST['project'];
            $this->load->model('mmodule');
            $this->load->model('msection');
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = $idProject;
            $searchData['idCRF'] = (isset($_REQUEST['crf']) && $_REQUEST['crf'] != '' && $_REQUEST['crf'] != 0 ? $_REQUEST['crf'] : 0);
            $searchData['idModule'] = (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] != 0 ? $_REQUEST['module'] : 0);
            $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
            $searchData['language'] = (isset($_REQUEST['language']) && $_REQUEST['language'] != '' ? $_REQUEST['language'] : 0);
            $result = $MSection->getCodeBookData($searchData);
            $data = $this->questionArr($result);
            $fileName = 'codebook_' . $data[0]->crf_name . '.xlsx';

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getProperties()->setCreator('Dictionary_portal')
                ->setLastModifiedBy('Dictionary_portal')
                ->setTitle('Dictionary_portal')
                ->setSubject('Dictionary_portal CodeBook Download')
                ->setDescription('Dictionary_portal CodeBook Download');
            // add style to the header
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                    'bottom' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array('rgb' => '333333'),
                    ),
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array('rgb' => '0d0d0d'),
                    'endColor' => array('rgb' => 'f2f2f2'),
                ),
            );
            $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleArray);
            // auto fit column to content
            foreach (range('A', 'Z') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            $sheet->SetCellValue('A1', 'Inst');
            $sheet->SetCellValue('B1', 'Variable Name');
            $sheet->SetCellValue('C1', 'Variable Label');
            $sheet->SetCellValue('D1', 'Answer Code');
            $sheet->SetCellValue('E1', 'Answer Label');
            $sheet->SetCellValue('F1', 'Type');
            $sheet->SetCellValue('G1', 'Table Name');
            $sheet->SetCellValue('H1', 'Question');

            $rowCount = 1;

            foreach ($data as $list) {
                $rowCount++;
                if (isset($list->option_value) && $list->option_value != '' && $list->option_value != null) {
                    $op = $list->option_value;
                    $li = $list->label_l1;
                } else {
                    $op = '';
                    $li = '';
                }
                $sheet->SetCellValue('A' . $rowCount, $list->crf_name);
                $sheet->SetCellValue('B' . $rowCount, strtolower($list->variable_name));
                $sheet->SetCellValue('C' . $rowCount, $list->label_l1);
                $sheet->SetCellValue('D' . $rowCount, $op);
                $sheet->SetCellValue('E' . $rowCount, $li);
                $sheet->SetCellValue('F' . $rowCount, $list->dbType);
                $sheet->SetCellValue('G' . $rowCount, $list->tableName);
                $sheet->SetCellValue('H' . $rowCount, $list->nature);

                if (isset($list->myrow_options) && $list->myrow_options != '') {
                    foreach ($list->myrow_options as $options) {
                        $rowCount++;
                        $sheet->SetCellValue('A' . $rowCount, $options->crf_name);
                        if ($list->nature == 'CheckBox' ) {
                            $sheet->SetCellValue('B' . $rowCount, strtolower($options->variable_name));
                            $sheet->SetCellValue('C' . $rowCount, $options->label_l1);
                            $rowCount++;
                            $sheet->SetCellValue('C' . $rowCount, '');
                            $sheet->SetCellValue('D' . $rowCount, $options->option_value);
                            $sheet->SetCellValue('E' . $rowCount, $options->label_l1);
                            $sheet->SetCellValue('F' . $rowCount, '');
                            $sheet->SetCellValue('G' . $rowCount, $options->tableName);
                            $sheet->SetCellValue('H' . $rowCount, $options->nature);
                        } else {
                            $sheet->SetCellValue('B' . $rowCount, '');
                            $sheet->SetCellValue('C' . $rowCount, '');
                            $sheet->SetCellValue('D' . $rowCount, $options->option_value);
                            $sheet->SetCellValue('E' . $rowCount, $options->label_l1);
                            $sheet->SetCellValue('F' . $rowCount, '');
                            $sheet->SetCellValue('G' . $rowCount, $options->tableName);
                            $sheet->SetCellValue('H' . $rowCount, $options->nature);
                        }


//                        if (($list->nature == 'Radio' && $options->nature == 'Input') || $options->nature == 'CheckBox' || $list->nature == 'CheckBox') {
                        if ($list->nature == 'Radio' && ($options->nature == 'Input' || $options->nature == 'Input-Numeric' || $options->nature == 'Date'
                                || $options->nature == 'Time')) {
                            $rowCount++;
                            $sheet->SetCellValue('A' . $rowCount, $options->crf_name);
                            $sheet->SetCellValue('B' . $rowCount, strtolower($options->variable_name) . 'x');
                            $sheet->SetCellValue('C' . $rowCount, $options->label_l1);
                            $sheet->SetCellValue('D' . $rowCount, '');
                            $sheet->SetCellValue('E' . $rowCount, '');
                            $sheet->SetCellValue('F' . $rowCount, '');
                            $sheet->SetCellValue('G' . $rowCount, $options->tableName);
                            $sheet->SetCellValue('H' . $rowCount, $options->nature);
                        } elseif ($list->nature == 'CheckBox' && ($options->nature == 'Input' || $options->nature == 'Input-Numeric' || $options->nature == 'Date'
                                || $options->nature == 'Time')) {
                            $rowCount++;
                            $sheet->SetCellValue('A' . $rowCount, $options->crf_name);
                            $sheet->SetCellValue('B' . $rowCount, strtolower($options->variable_name) . 'x');
                            $sheet->SetCellValue('C' . $rowCount, $options->label_l1);
                            $sheet->SetCellValue('D' . $rowCount, '');
                            $sheet->SetCellValue('E' . $rowCount, '');
                            $sheet->SetCellValue('F' . $rowCount, '');
                            $sheet->SetCellValue('G' . $rowCount, $options->tableName);
                            $sheet->SetCellValue('H' . $rowCount, $options->nature);
                        }
                    }
                }
            }
            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); // download file
            //End Function index
        } else {
            echo 'Invalid Project, Please select project';
        }
    }

    function getExcel()
    {
        ob_end_clean();
        $this->load->model('msection');
        $fileName = 'data_dictionaryportal_' . time() . '.xlsx';
        if (isset($_GET['project']) && $_GET['project'] != '' && $_GET['project'] != 0) {
            $MSection = new MSection();
            $searchData = array();
            $searchData['idProjects'] = (isset($_GET['project']) && $_GET['project'] != '' && $_GET['project'] != 0 ? $_GET['project'] : 0);
            $searchData['idCRF'] = (isset($_GET['crf']) && $_GET['crf'] != '' && $_GET['crf'] != 0 ? $_GET['crf'] : 0);
            $searchData['idModule'] = (isset($_GET['module']) && $_GET['module'] != '' && $_GET['module'] != 0 ? $_GET['module'] : 0);
            $searchData['idSection'] = (isset($_GET['section']) && $_GET['section'] != '' && $_GET['section'] != 0 ? $_GET['section'] : 0);
            $searchData['type'] = 1;
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getProperties()->setCreator('Dictionary_portal')
                ->setLastModifiedBy('Dictionary_portal')
                ->setTitle('Dictionary_portal')
                ->setSubject('Dictionary_portal Excel Download')
                ->setDescription('Dictionary_portal Excel Download');
            // add style to the header
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                    'bottom' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array('rgb' => '333333'),
                    ),
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array('rgb' => '0d0d0d'),
                    'endColor' => array('rgb' => 'f2f2f2'),
                ),
            );
            $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleArray);
            // auto fit column to content
            foreach (range('A', 'Z') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            $sheet->SetCellValue('A1', 'Variable');
            $sheet->SetCellValue('B1', 'Type');
            $sheet->SetCellValue('C1', 'Language 1');
            $sheet->SetCellValue('D1', 'Language 2');
            $sheet->SetCellValue('E1', 'Language 3');
            $sheet->SetCellValue('F1', 'Language 4');
            $sheet->SetCellValue('G1', 'Language 5');
            $sheet->SetCellValue('H1', 'Values');
            $sheet->SetCellValue('I1', 'Skip');
            $sheet->SetCellValue('J1', 'Parent');
            $sheet->SetCellValue('K1', 'Min Range');
            $sheet->SetCellValue('L1', 'Max Range');
            $sheet->SetCellValue('M1', 'Instruction 1');
            $sheet->SetCellValue('N1', 'Instruction 2');
            $sheet->SetCellValue('O1', 'Instruction 3');
            $sheet->SetCellValue('P1', 'Instruction 4');
            $sheet->SetCellValue('Q1', 'Instruction 5');
            $sheet->SetCellValue('R1', 'ID');
            $sheet->SetCellValue('S1', 'Crf');
            $sheet->SetCellValue('T1', 'Section');


            $rowCount = 1;
            foreach ($data as $list) {
                $rowCount++;
                $sheet->SetCellValue('A' . $rowCount, $list->variable_name);
                $sheet->SetCellValue('B' . $rowCount, $list->nature);
                $sheet->SetCellValue('C' . $rowCount, $list->label_l1);
                $sheet->SetCellValue('D' . $rowCount, $list->label_l2);
                $sheet->SetCellValue('E' . $rowCount, $list->label_l3);
                $sheet->SetCellValue('F' . $rowCount, $list->label_l4);
                $sheet->SetCellValue('G' . $rowCount, $list->label_l5);
                $sheet->SetCellValue('H' . $rowCount, $list->option_value);
                $sheet->SetCellValue('I' . $rowCount, $list->skipQuestion);
                $sheet->SetCellValue('J' . $rowCount, $list->idParentQuestion);
                $sheet->SetCellValue('K' . $rowCount, $list->MinVal);
                $sheet->SetCellValue('L' . $rowCount, $list->MaxVal);
                $sheet->SetCellValue('M' . $rowCount, $list->instruction_l1);
                $sheet->SetCellValue('N' . $rowCount, $list->instruction_l2);
                $sheet->SetCellValue('O' . $rowCount, $list->instruction_l3);
                $sheet->SetCellValue('P' . $rowCount, $list->instruction_l4);
                $sheet->SetCellValue('Q' . $rowCount, $list->instruction_l5);
                $sheet->SetCellValue('R' . $rowCount, $list->idSectionDetail);
                $sheet->SetCellValue('S' . $rowCount, $list->id_crf);
                $sheet->SetCellValue('T' . $rowCount, $list->idSection);
                if (isset($list->myrow_options) && $list->myrow_options != '') {
                    foreach ($list->myrow_options as $options) {
                        $rowCount++;
                        $sheet->SetCellValue('A' . $rowCount, $options->variable_name);
                        $sheet->SetCellValue('B' . $rowCount, $options->nature);
                        $sheet->SetCellValue('C' . $rowCount, $options->label_l1);
                        $sheet->SetCellValue('D' . $rowCount, $options->label_l2);
                        $sheet->SetCellValue('E' . $rowCount, $options->label_l3);
                        $sheet->SetCellValue('F' . $rowCount, $options->label_l4);
                        $sheet->SetCellValue('G' . $rowCount, $options->label_l5);
                        $sheet->SetCellValue('H' . $rowCount, $options->option_value);
                        $sheet->SetCellValue('I' . $rowCount, $options->skipQuestion);
                        $sheet->SetCellValue('J' . $rowCount, $options->idParentQuestion);
                        $sheet->SetCellValue('K' . $rowCount, $options->MinVal);
                        $sheet->SetCellValue('L' . $rowCount, $options->MaxVal);
                        $sheet->SetCellValue('M' . $rowCount, '');
                        $sheet->SetCellValue('N' . $rowCount, '');
                        $sheet->SetCellValue('O' . $rowCount, '');
                        $sheet->SetCellValue('P' . $rowCount, '');
                        $sheet->SetCellValue('Q' . $rowCount, '');
                        $sheet->SetCellValue('R' . $rowCount, $options->idSectionDetail);
                        $sheet->SetCellValue('S' . $rowCount, $options->id_crf);
                        $sheet->SetCellValue('T' . $rowCount, $options->idSection);

                    }
                }
            }
            //Create file excel.xlsx
            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); // download file
            //End Function index

        } else {
            echo 'Invalid Project';
        }
    }

    function getTableQuery()
    {
        ob_end_clean();
        $MSection = new MSection();
        $searchData = array();
        $searchData['idSection'] = (isset($_REQUEST['section']) && $_REQUEST['section'] != '' && $_REQUEST['section'] != 0 ? $_REQUEST['section'] : 0);
        $getTableName = $MSection->getSectionDataById($searchData);
        if (isset($getTableName[0]->tableName) && $getTableName[0]->tableName != '') {
            $tableName = $getTableName[0]->tableName;
            $result = $MSection->getSectionDetailData($searchData);
            $data = $this->questionArr($result);
            $queryPrint = "CREATE TABLE " . $tableName . " (  \n";
            foreach ($data as $list) {
                $queryPrint .= strtolower($list->variable_name) . " " . (isset($list->dbType) && $list->dbType != '' ? $list->dbType : 'varchar') . "(" . (isset($list->dbType) && $list->dbType != '' ? $list->dbLength : '255') . "), " . "\n";
                if (isset($list->myrow_options) && $list->myrow_options != '') {
                    foreach ($list->myrow_options as $options) {
                        if (($list->nature == 'Radio' && $options->nature == 'Input') || $options->nature == 'CheckBox' || $list->nature == 'CheckBox') {
                            $queryPrint .= strtolower($options->variable_name) . " " . (isset($options->dbType) && $options->dbType != '' ? $options->dbType : 'varchar') . "(" . (isset($options->dbType) && $options->dbType != '' ? $options->dbLength : '255') . "), " . "\n";
                        }
                    }
                }
            }
            $queryPrint .= "  );";
            echo $queryPrint;
        } else {
            echo 'Invalid Table Name';
        }
    }

} ?>