<?php

namespace App;
class Cart
{
    public $posts;
    public $totalQty;
    public $totalAmount;

    public function __construct($oldPost)
    {
        if($oldPost){
            $this->posts=$oldPost->posts;
            $this->totalQty=$oldPost->totalQty;
            $this->totalAmount=$oldPost->totalAmount;
        }else{
            $this->posts=null;

        }
    }
    public function add($post){
        $storagePost=['post'=>$post,'amount'=>$post->price,'qty'=>0];
        if($this->posts){
            if(array_key_exists($post->id,$this->posts)){
                $storagePost=$this->posts[$post->id];
            }
        }
        $storagePost['qty']++;
        $storagePost['amount']=$storagePost['qty'] * $post->price;
        $this->posts[$post->id]=$storagePost;
        $this->totalQty++;
        $this->totalAmount +=$post->price;
    }

}
