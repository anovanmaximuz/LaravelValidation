<?php 
namespace Anovanmaximuz\LaravelValidation;

use Exception;

class Validation extends Exception{

    public static function validateHeaders($headers, $headerRoles=[], $raw=false) {
        //raw
        //name 
        //   -required=false
        //   -type=false
        //   -length=false
        $errors = [];
        $row = 0;
        foreach ($headerRoles as $header => $role){
            if (strpos($role, "required") !== false && !isset($headers[$header])) {
                if($raw){
                    $errors[$header]['required'] = false;
                }else{
                    $errors[$row][] = "Header ".$header." must be set";
                }
            }
            
            if(isset($headers[$header])){
                $roles = explode("|", $role);
                foreach ($roles as $rol){
                    if (strpos($rol, "min") !== false){
                        $mins = explode(":", $rol);
                        if(count($mins)>0 && count($mins)==2){
                            $minValue = $mins[1];
                            if(strlen($headers[$header])<$minValue){
                                if($raw){
                                    $errors[$header]['length'] = false;
                                }else{
                                    $errors[$row][] = "Minimum ".$minValue." characters allowed for header '".$header."' ";
                                }
                            }
                        }else{
                            $errors[$row][] = "Wrong minimum length format for header '".$header."', eq: min:5 ";
                        }
                    }
                    
                    if (strpos($rol, "max") !== false){
                        $maxs = explode(":", $rol);
                        if(count($maxs)>0 && count($maxs)==2){
                            $maxValue = $maxs[1];
                            if(strlen($headers[$header])>$maxValue){
                                if($raw){
                                    $errors[$header]['length'] = false;
                                }else{
                                    $errors[$row][] = "Maximum ".$maxValue." characters allowed for header '".$header."' ";
                                }
                            }
                        }else{
                            $errors[$row][] = "Wrong maximum length format for header '".$header."', eq: max:5 ";
                        }
                    }
                }
            }
            
            $row++;
        }



        if(count($errors)>0){
            if($raw){

            }else{
                $exceptions = [];
                foreach($errors as $error){
                    foreach($error as $logs){
                        $exceptions[] = $logs;
                    }
                }
            }

            return ['code'=>203, 'messages'=>($raw) ? "errors":$exceptions,'data'=>$errors];
        }else{
            return ['code'=>200];
        }
    }
}