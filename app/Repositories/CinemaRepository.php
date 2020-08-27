<?php

namespace App\Repositories;
use App\Cinema;
use Auth;
class CinemaRepository implements CinemaRepositoryInterface
{
    public function all()
    {
        return Cinema::all();
    }
    public function add($data)
    {
        $cinema=new Cinema;
        $cinema->user_id=Auth::user()->id;
        $cinema->name=$data->name;
        $cinema->venue=$data->venue;
        if($cinema->save()){
            return true;
        }else{
            return false;
        }
    }
    public function update($id,$data)
    {
        $cinema=Cinema::whereId($id)->firstorFail();
        $cinema->user_id=Auth::user()->id;
        $cinema->name=$data->name;
        if($cinema->save()){
            return true;
        }else{
            return false;
        }
    }
    public function delete($id)
    {
        $cinema=Cinema::whereId($id)->firstorFail();
        if($cinema->delete()){
            return true;
        }else{
            return false;
        }
    }
    public function updateShowTime($id,$data)
    {
        $cinema=Cinema::whereId($id)->firstorFail();
        $mydata=$cinema->pivot->whereMovie_id($data->movie_id)->firstorFail();
        $mydata->pivot->time=$data->time;
        $mydata->pivot->date=$data->date;
        if($mydata->save()){
            return true;
        }
        return false;
    }
    public function addShowTime($data)
    {
        $cinema=Cinema::whereId($data->cinema_id)->firstorFail();
       
        $mydata=$cinema->movies()->attach($data->movie_id,[
            
            'time'=>$data->time,
            'date'=>$data->date,
            'user_id'=>Auth::user()->id    
        ]);
      
            return true;
    }
    public function deleteShowTime($id,$myid){
        $cinema=Cinema::whereId($myid)->firstorFail();
        if($cinema->pivot->whereMovie_id($id)->delete())
        {
            return true;
        }
        return  false;
    }
    public function showTime(){
        return Cinema::whereHas('movies')->with('movies')->get();
    }
    public function findById($id)
    {
        return Cinema::whereId($id)->firstOrFail();
    }
    public function findByDate($date)
    {

    }
    public function findByIdAndCinema($id,$myid)
    {
        $cinema=Cinema::whereId($id)->firstOrFail();
        return $cinema->movies()->whereMovie_id($id)->firstOrFail();
    }
    public function findByCinema($name)
    {

    }
}