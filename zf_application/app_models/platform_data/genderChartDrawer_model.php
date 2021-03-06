<?php

//THIS CODE IS WRITTEN BY:
          //1. ATHIAS AVIANS (MATHEW JUMA), THE CHIEF AND CORE DEVELOPER OF ZILAS FRAMEWORK PROJECT.
          

/*
 * ---------------------------------------------------------------------
 * |                                                                   |
 * |  This the Index Model which is responsible responsible for        |
 * |  handling all logics that are related to the template Controller  |
 * |                                                                   |
 * ---------------------------------------------------------------------
 */

class GenderChartDrawer_Model extends Zf_Model {
    
    //This holds the session user details.
    private $sessionUser;
    

   /*
    * --------------------------------------------------------------------------------------
    * |                                                                                    |
    * |  The is the main class constructor. It runs automatically within any class object  |
    * |                                                                                    |
    * --------------------------------------------------------------------------------------
    */
    public function __construct() {
        
         parent::__construct();
         
         $this->sessionUser = Zf_SessionHandler::zf_getSessionVariable("ttv_identificationCode");
         
    }
    
    
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO AGE DISTRIBUTION.
     * =========================================================================
     */
    public function AgeDistribution($dataFilter){
        
        $dataFilter = explode('_' , $dataFilter);
        
        $gender = $dataFilter[0]; 
        
        $ageRange = explode(";", $dataFilter[1]);
        
        
        $table = "ttv_customerData";
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getAge25 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='18-25' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge35 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='26-35' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge50 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='36-50' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge51 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='51 +' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){
            
            $getAge25 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='18-25' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge35 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='26-35' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge50 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='36-50' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge51 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='51 +' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
            
            $getAge25 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='18-25' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge35 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='26-35' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge50 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='36-50' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getAge51 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and ageBracket ='51 +' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            
        }
        
        
        $executeAge25   = $this->Zf_AdoDB->Execute($getAge25);
        $executeAge35   = $this->Zf_AdoDB->Execute($getAge35);
        $executeAge50   = $this->Zf_AdoDB->Execute($getAge50);
        $executeAge51   = $this->Zf_AdoDB->Execute($getAge51);
        
        if (!$executeAge25){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $age25Count = $executeAge25->RecordCount();
            
        }
 
        if (!$executeAge35){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $age35Count = $executeAge35->RecordCount();
            
        }
 
        if (!$executeAge50){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $age50Count = $executeAge50->RecordCount();
            
        }
 
        if (!$executeAge51){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $age51Count = $executeAge51->RecordCount();
            
        }
        
        if($age25Count == 0 && $age35Count == 0  && $age50Count == 0 && $age51Count == 0){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
        $strXML .= "<set label='18 - 25' value=' ".$age25Count." ' tooltext=' Age brackets 18 - 25 years{br}Total count: ".$age25Count." people,{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='26 - 35' value=' ".$age35Count." ' tooltext=' Age brackets 26 - 35 years{br}Total count: ".$age35Count." people,{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='36 - 50' value=' ".$age50Count." ' tooltext=' Age brackets 36 -50 years{br}Total count: ".$age50Count." people,{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='51+' value=' ".$age51Count." ' tooltext=' Age brackets over 50 years{br}Total count: ".$age51Count." people,{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "
                    <styles>
                        <definition>
                              <style name='myToolTipFont' type='font' font='ProximaNova-Light' size='11' color='87b6d9'/>
                        </definition>
                        <application>
                              <apply toObject='ToolTip' styles='myToolTipFont' />
                        </application>
                    </styles> 

                   ";
        $strXML .= "</chart>";

        $zf_chartData = array(

            "chartData"         => "$strXML",
            "chartType"         => "Pie2D",
            "chartId"           => "customerAge",
            "chartWidth"        => "100%",
            "chartHeight"       => 280,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
 
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO MARITAL STATUS.
     * =========================================================================
     */
    public function MaritalStatus($dataFilter){
        
        $dataFilter = explode('_' , $dataFilter);
        
        $gender = $dataFilter[0]; 
        
        $ageRange = explode(";", $dataFilter[1]);
        
        
        $table = "ttv_customerData";
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getSingle   = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Single' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getMarried  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Married' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDivorced = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Divorced' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getWidowed  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Widowed' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){
            
            $getSingle   = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Single' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getMarried  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Married' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDivorced = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Divorced' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getWidowed  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Widowed' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getSingle   = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Single' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getMarried  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Married' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDivorced = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Divorced' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getWidowed  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and maritalStatus ='Widowed' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            
        }
        
        $executeSingle   = $this->Zf_AdoDB->Execute($getSingle);
        $executeMarried   = $this->Zf_AdoDB->Execute($getMarried);
        $executeDivorced   = $this->Zf_AdoDB->Execute($getDivorced);
        $executeWidowed   = $this->Zf_AdoDB->Execute($getWidowed);
        
        if (!$executeSingle){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $singleCount = $executeSingle->RecordCount();
            
        }
 
        if (!$executeMarried){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $marriedCount = $executeMarried->RecordCount();
            
        }
 
        if (!$executeDivorced){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $divorcedCount = $executeDivorced->RecordCount();
            
        }
 
        if (!$executeWidowed){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $widowedCount = $executeWidowed->RecordCount();
            
        }
        
        if($singleCount == 0 && $marriedCount == 0 && $divorcedCount == 0 && $widowedCount == 0 ){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Single' value=' ".$singleCount." ' tooltext=' Singles count: ".$singleCount.",{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='Married' value=' ".$marriedCount." ' tooltext=' Married count: ".$marriedCount.",{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='Divorced' value=' ".$divorcedCount." ' tooltext=' Divorced count: ".$divorcedCount.",{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='Widowed' value=' ".$widowedCount." ' tooltext=' Widowed count: ".$widowedCount.",{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "
                    <styles>
                        <definition>
                              <style name='myToolTipFont' type='font' font='ProximaNova-Light' size='11' color='87b6d9'/>
                        </definition>
                        <application>
                              <apply toObject='ToolTip' styles='myToolTipFont' />
                        </application>
                    </styles> 

                   ";
        $strXML .= "</chart>";

        $zf_chartData = array(

            "chartData"         => "$strXML",
            "chartType"         => "Pie2D",
            "chartId"           => "customerMaritalStatus",
            "chartWidth"        => "100%",
            "chartHeight"       => 280,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO EDUCATION LEVEL.
     * =========================================================================
     */
    public function EducationLevel($dataFilter){
        
        $dataFilter = explode('_' , $dataFilter);
        
        $gender = $dataFilter[0]; 
        
        $ageRange = explode(";", $dataFilter[1]);
        
        
        $table = "ttv_customerData";
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getNone       = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='None' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getPrimary    = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Primary' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getSecondary  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Secondary' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDiploma    = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Diploma' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getUniversity = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='University' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){
            
            $getNone       = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='None' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getPrimary    = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Primary' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getSecondary  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Secondary' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDiploma    = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Diploma' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getUniversity = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='University' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
            
            $getNone       = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='None' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getPrimary    = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Primary' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getSecondary  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Secondary' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDiploma    = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='Diploma' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getUniversity = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and educationLevel ='University' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            
        }
        
        $executeNone         = $this->Zf_AdoDB->Execute($getNone);
        $executePrimary      = $this->Zf_AdoDB->Execute($getPrimary);
        $executeSecondary    = $this->Zf_AdoDB->Execute($getSecondary);
        $executeDiploma      = $this->Zf_AdoDB->Execute($getDiploma);
        $executeUniversity   = $this->Zf_AdoDB->Execute($getUniversity);
        
        if (!$executeNone){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $noneCount = $executeNone->RecordCount();
            
        }
 
        
        if (!$executePrimary){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $primaryCount = $executePrimary->RecordCount();
            
        }
 
        
        if (!$executeSecondary){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $secondaryCount = $executeSecondary->RecordCount();
            
        }
 
        
        if (!$executeDiploma){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $diplomaCount = $executeDiploma->RecordCount();
            
        }
 
        
        if (!$executeUniversity){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $universityCount = $executeUniversity->RecordCount();
            
        }
 
        if($noneCount == 0 && $primaryCount == 0 && $secondaryCount == 0 && $diplomaCount == 0 && $universityCount == 0){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='80' legendPosition='BOTTOM' >";
        $strXML .= "<set label='None' value=' ".$noneCount." ' tooltext=' None count: ".$noneCount.",{br}Click for a detailed{br}information ' link=' ' />";
        $strXML .= "<set label='Primary' value=' ".$primaryCount." ' tooltext=' Primary count: ".$primaryCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Secondary' value=' ".$secondaryCount." '  tooltext=' Secondary count: ".$secondaryCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Diploma' value=' ".$diplomaCount." '  tooltext=' Diploma count: ".$diplomaCount.",{br}Click for a detailed{br}information ' link=' ' />";
        $strXML .= "<set label='University' value=' ".$universityCount." '  tooltext=' University count: ".$universityCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "
                    <styles>
                        <definition>
                              <style name='myToolTipFont' type='font' font='ProximaNova-Light' size='11' color='87b6d9'/>
                        </definition>
                        <application>
                              <apply toObject='ToolTip' styles='myToolTipFont' />
                        </application>
                    </styles> 

                   ";
        $strXML .= "</chart>";

        $zf_chartData = array(

            "chartData"         => "$strXML",
            "chartType"         => "Pie2D",
            "chartId"           => "customerEducation",
            "chartWidth"        => "100%",
            "chartHeight"       => 240,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
 
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO OCCUPATION.
     * =========================================================================
     */
    public function Occupation($dataFilter){
        
        $dataFilter = explode('_' , $dataFilter);
        
        $gender = $dataFilter[0]; 
        
        $ageRange = explode(";", $dataFilter[1]);
        
        
        $table = "ttv_customerData";
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getOthers       = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Others' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getFarmer       = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Farmer' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getShopOwner    = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Shop Owner' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getProfessional = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Professional' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){
            
            $getOthers        = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Others' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getFarmer        = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Farmer' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getShopOwner     = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Shop Owner' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getProfessional  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Professional' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getOthers        = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Others' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getFarmer        = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Farmer' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getShopOwner     = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Shop Owner' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getProfessional  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and occupation ='Professional' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            
        }
        
        $executeOthers       = $this->Zf_AdoDB->Execute($getOthers);
        $executeFarmer       = $this->Zf_AdoDB->Execute($getFarmer);
        $executeShopOwner    = $this->Zf_AdoDB->Execute($getShopOwner);
        $executeProfessional = $this->Zf_AdoDB->Execute($getProfessional);
        
        if (!$executeOthers){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $othersCount = $executeOthers->RecordCount();
            
        }
 
        if (!$executeFarmer){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $farmerCount = $executeFarmer->RecordCount();
            
        }
 
        if (!$executeShopOwner){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $shopOwnerCount = $executeShopOwner->RecordCount();
            
        }
 
        if (!$executeProfessional){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $professionalCount = $executeProfessional->RecordCount();
            
        }
        
        if($othersCount == 0 && $farmerCount == 0 && $shopOwnerCount == 0 && $professionalCount == 0){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='80' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Others' value=' ".$othersCount." ' tooltext=' Others count: ".$othersCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Farmers' value=' ".$farmerCount." ' tooltext=' Farmers count: ".$farmerCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Shop Owners' value=' ".$shopOwnerCount." ' tooltext=' Shop owners count: ".$shopOwnerCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Professional' value=' ".$professionalCount." ' tooltext=' Professionals count: ".$professionalCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "
                    <styles>
                        <definition>
                              <style name='myToolTipFont' type='font' font='ProximaNova-Light' size='11' color='87b6d9'/>
                        </definition>
                        <application>
                              <apply toObject='ToolTip' styles='myToolTipFont' />
                        </application>
                    </styles> 

                   ";
        $strXML .= "</chart>";

        $zf_chartData = array(

            "chartData"         => "$strXML",
            "chartType"         => "Pie2D",
            "chartId"           => "customerOccupation",
            "chartWidth"        => "100%",
            "chartHeight"       => 240,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ANNUAL INCOME.
     * =========================================================================
     */
    public function AnnualIncome($dataFilter){
        
        $dataFilter = explode('_' , $dataFilter);
        
        $gender = $dataFilter[0]; 
        
        $ageRange = explode(";", $dataFilter[1]);
        
        
        $table = "ttv_customerData";
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getIncome5000  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='0-5000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome10000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='5001-10000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome20000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='10001-20000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='20001-50000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50001 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='50001 +' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){
            
            $getIncome5000  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='0-5000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome10000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='5001-10000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome20000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='10001-20000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='20001-50000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50001 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='50001 +' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
            
            $getIncome5000  = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='0-5000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome10000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='5001-10000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome20000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='10001-20000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50000 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='20001-50000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50001 = "SELECT * FROM " . $table . " WHERE gender ='".$gender."' and monthlyIncome ='50001 +' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            
        }
        
        $executeIncome5000  = $this->Zf_AdoDB->Execute($getIncome5000);
        $executeIncome10000 = $this->Zf_AdoDB->Execute($getIncome10000);
        $executeIncome20000 = $this->Zf_AdoDB->Execute($getIncome20000);
        $executeIncome50000 = $this->Zf_AdoDB->Execute($getIncome50000);
        $executeIncome50001 = $this->Zf_AdoDB->Execute($getIncome50001);
        
        if (!$executeIncome5000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income5000Count = $executeIncome5000->RecordCount();
            
        }
 
        if (!$executeIncome10000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income10000Count = $executeIncome10000->RecordCount();
            
        }
 
        if (!$executeIncome20000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income20000Count = $executeIncome20000->RecordCount();
            
        }
 
        if (!$executeIncome50000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income50000Count = $executeIncome50000->RecordCount();
            
        }
 
        if (!$executeIncome50001){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income50001Count = $executeIncome50001->RecordCount();
            
        }
        
        if($income5000Count == 0 && $income10000Count == 0 && $income20000Count == 0 && $income50000Count == 0 && $income50001Count == 0){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='80' legendPosition='BOTTOM' >";
        $strXML .= "<set label='0 - 60K' value=' ".$income5000Count." ' tooltext='Annual salary below 60,001 (Kshs){br}Total count:  ".$income5000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='60K - 120K' value=' ".$income10000Count." ' tooltext=' Annual salary between 60,001 - 120,000 (Kshs){br}Total count:  ".$income10000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='120K - 240K' value=' ".$income20000Count." ' tooltext=' Annual salary between 120,001 - 240,000 (Kshs){br}Total count:  ".$income20000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='240K - 600K' value=' ".$income50000Count." ' tooltext=' Annual salary between 240,001 - 600,000 (Kshs){br}Total count:  ".$income50000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='Above 600K' value=' ".$income50001Count." ' tooltext=' Annual salary above 600,001 (Kshs){br}Total count:  ".$income50001Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "
                    <styles>
                        <definition>
                              <style name='myToolTipFont' type='font' font='ProximaNova-Light' size='11' color='87b6d9'/>
                        </definition>
                        <application>
                              <apply toObject='ToolTip' styles='myToolTipFont' />
                        </application>
                    </styles> 

                   ";
        $strXML .= "</chart>";

        $zf_chartData = array(

            "chartData"         => "$strXML",
            "chartType"         => "Pie2D",
            "chartId"           => "customerAnnualIncome",
            "chartWidth"        => "100%",
            "chartHeight"       => 240,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
 
        
    }

}

?>

