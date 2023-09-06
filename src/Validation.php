<?php 
namespace Anovanmaximuz\LaravelValidation;

use DateTime;

class Validation{

    public static function cheks($params, $paramsRoles=[], $model='header', $raw=false) {
        //raw
        //name 
        //   -required=false
        //   -type=false
        //   -length=false
        $errors = [];
        $row = 0;
        foreach ($paramsRoles as $param => $role){
            $errors[$param]['required'] = true;
            $errors[$param]['length'] = true;
            $errors[$param]['type'] = true;
            if (strpos($role, "required") !== false && !isset($params[$param])) {
                if($raw){
                    $errors[$param]['required'] = false;
                }else{
                    $errors[$row][] = $model." ".$param." must be set";
                }
            }
            
            if(isset($params[$param])){
                $roles = explode("|", $role);
                foreach ($roles as $rol){
                    if (strpos($rol, "min") !== false){
                        $mins = explode(":", $rol);
                        if(count($mins)>0 && count($mins)==2){
                            $minValue = $mins[1];
                            if(strlen($params[$header])<$minValue){
                                if($raw){
                                    $errors[$param]['length'] = false;
                                }else{
                                    $errors[$row][] = "Minimum ".$minValue." characters allowed for $model '".$param."' ";
                                }
                            }
                        }else{
                            $errors[$row][] = "Wrong minimum length format for $model '".$param."', eq: min:5 ";
                        }
                    }
                    
                    if (strpos($rol, "max") !== false){
                        $maxs = explode(":", $rol);
                        if(count($maxs)>0 && count($maxs)==2){
                            $maxValue = $maxs[1];
                            if(strlen($params[$param])>$maxValue){
                                if($raw){
                                    $errors[$param]['length'] = false;
                                }else{
                                    $errors[$row][] = "Maximum ".$maxValue." characters allowed for $model '".$param."' ";
                                }
                            }
                        }else{
                            $errors[$row][] = "Wrong maximum length format for $model '".$param."', eq: max:5 ";
                        }
                    }
                    
                    if (strpos($rol, "date") !== false){
                        if(!self::validateDate($params[$param])){
                            if($raw){
                                $errors[$param]['type'] = false;
                            }else{
                                $errors[$row][] = "Invalid date format for $model '".$param."' ";
                            }
                        }
                    }
                    
                    if (strpos($rol, "int") !== false){
                        if(!is_numeric($params[$param])){
                            if($raw){
                                $errors[$param]['type'] = false;
                            }else{
                                $errors[$row][] = "Invalid int format for $model '".$param."' ";
                            }
                        }
                    }
                    
                    if (strpos($rol, "string") !== false){
                        if(!is_string($params[$param])){
                            if($raw){
                                $errors[$param]['type'] = false;
                            }else{
                                $errors[$row][] = "Invalid int format for $model '".$param."' ";
                            }
                        }
                    }
                }
            }
            
            $row++;
            if($errors[$param]['required'] == true &&
            $errors[$param]['length'] == true &&
            $errors[$param]['type'] == true){
                unset($errors[$param]);
            }
        }
        


        if(count($errors)>0){
            $data = [];
            $exceptions = [];
            $groups = [];
            if($raw){
                $data = $errors;
                foreach ($errors as $error => $val){
                    $groups[]=$error;
                }
            }else{                
                foreach($errors as $error){
                    foreach($error as $logs){
                        $exceptions[] = $logs;
                    }
                }
            }

            return ['code'=>203, 'messages'=>$exceptions,'data'=>$data,'group'=>$groups];
        }else{
            return ['code'=>200];
        }        
    }
    
    public static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}