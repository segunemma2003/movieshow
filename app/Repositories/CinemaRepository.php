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
        $cinema->venue=$data->venue;
        if($cinema->save()){
            return true;
        }else{
            return false;
        }
    }
    public function delete($id)
    {
        $cinema=Cinema::whereId($id)->firstorFail();
        $cinema->movies()->detach($id);
        if($cinema->delete()){
            return true;
        }else{
            return false;
        }
    }
    public function updateShowTime($id,$myid,$data)
    {
        $cinema=Cinema::whereId($myid)->firstorFail();
        
        $mydata=$cinema->movies()->wherePivot('id',$id)
        
        ->updateExistingPivot($data->movie_id,[
            'time'=>$data->time,
            'date'=>$data->date,
            'movie_id'=>$data->movie_id,
            'cinema_id'=>$data->cinema_id,
            'user_id'=>Auth::user()->id
        ]);
       
       if($mydata){
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
        if($cinema->movies()->newPivotStatement()->where('id',$id)->delete())
        {
            return true;
        }
        return  false;
    }
    public function showTime(){
        $cinema=Cinema::whereHas('movies')->with('movies')->get();
        return $cinema;
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
       
        $cinemas=Cinema::whereId($myid)->firstOrFail();
        $cinema=$cinemas->movies()->wherePivot('id',$id)->first();
       
        return [
            'movies'=>$cinema,
            'cinema'=>$cinemas
        ];
    }
    public function findByCinema($name)
    {

    }
}