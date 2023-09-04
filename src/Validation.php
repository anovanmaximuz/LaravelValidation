<?php 
namespace Anovanmaximuz\LaravelValidation;

use Exception;

class Validation extends Exception{

    public static function validateHeaders($headers, $headerRoles=[]) {

        $errors = [];
        $row = 0;
        foreach ($headerRoles as $header => $role){
            if (strpos($role, "required") !== false && !isset($headers[$header])) {
                $errors[$row][] = "Header ".$header." must be set";
            }
            
            if(isset($headers[$header])){
                $roles = explode("|", $role);
                foreach ($roles as $rol){
                    if (strpos($rol, "min") !== false){
                        $mins = explode(":", $rol);
                        if(count($mins)>0 && count($mins)==2){
                            $minValue = $mins[1];
                            if(strlen($headers[$header])<$minValue){
                                $errors[$row][] = "Minimum length ".$minValue." allowed";
                            }
                        }else{
                            $errors[$row][] = "Wrong minimum length format";
                        }
                    }
                    
                    if (strpos($rol, "max") !== false){
                        $maxs = explode(":", $rol);
                        if(count($maxs)>0 && count($mins)==2){
                            $maxValue = $maxs[1];
                            if(strlen($headers[$header])>$maxValue){
                                $errors[$row][] = "Maximum length ".$maxValue." allowed";
                            }
                        }else{
                            $errors[$row][] = "Wrong maximum length format";
                        }
                    }
                }
            }
            
            $row++;
        }



        if(count($errors)>0){
            $exceptions = [];
            foreach($errors as $error){
                foreach($error as $logs){
                    $exceptions[] = $logs;
                }
            }

            throw new Exception($exceptions[0]);
        }else{
            return true;
        }
    }
}