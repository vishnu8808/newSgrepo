
<?php
use App\Models\User;   
use App\Models\Commision;  
use App\Models\Levels; 

    if (!function_exists('getChildNodes')) {
        function getChildNodes($id) {
            $nodeArr=[];
            $node= User::with('allChildren')->find($id); 
            array_push($nodeArr,$node->id); // Current Node
            foreach ($node->allChildren as $child) {
                array_push($nodeArr,$child->id); // Direct Node
                foreach ($child->allChildren as $subChild) {
                    array_push($nodeArr,$subChild->id);; // All descendants
                }
            }
            return $nodeArr;
        }
    }


    if (!function_exists('addCommision')) {
        function addCommision($id,$amount,$sales_id) { 
            $com_amount=0;
            $rate=0;
            $user_data= User::find($id); 
            if($user_data->parent_id){

                $parent_data=User::with('levels')->find($user_data->parent_id);
                $rate=$parent_data->levels->rate;
                $com_amount=$amount*($rate/100);
                $sale = Commision::Insert([
                    'sales_id' => $sales_id,
                    'user_id' => $user_data->parent_id,
                    'com_amount' => $com_amount,
                    'rate'=>$rate,
                    'created_at'=>date('Y-m-d')
                ]);

                addCommision($user_data->parent_id,$amount,$sales_id);

            }else{
                return true; 
            }
          
        }
    }

?>