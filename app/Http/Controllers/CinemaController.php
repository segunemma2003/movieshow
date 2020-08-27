<?php

namespace App\Http\Controllers;

use App\Cinema;
use Illuminate\Http\Request;
use App\Repositories\CinemaRepositoryInterface;
use App\Repositories\MovieRepositoryInterface;
use App\Http\Requests\CinemaRequest;
use App\Http\Requests\CinemaMovieRequest;
class CinemaController extends Controller
{
    

     private $cinemarepository;
     private $movierepository;

    public function __construct(CinemaRepositoryInterface $cinemarepository,MovieRepositoryInterface $movierepository)
    {
        $this->cinemarepository=$cinemarepository;
        $this->movierepository=$movierepository;
    }
    public function index()
    {
        $cinemas=$this->cinemarepository->all();

        return view('cinema',compact('cinemas'));
    }
    public function showCreateCinema()
    {
    
        return view('cinema_create');
    }
    public function showIndex()
    {
        $shows=$this->cinemarepository->showTime();
  
        return view('home',compact('shows'));
    }
    public function showEditCinema($id)
    {
        $cinema=$this->cinemarepository->findById($id);
        return view('cinema_update',compact('cinema'));
    }
    public function createCinema(CinemaRequest $request)
    {
        if($this->cinemarepository->add($request))
        {
            return redirect()->route('cinema');
        }
    }
    public function updateCinema(CinemaRequest $request,$id)
    {
        if($this->cinemarepository->update($id,$request))
        {
            return redirect()->route('cinema');
        }
    }
    public function deleteCinema($id)
    {
        if($this->cinemarepository->delete($id))
        {
            return redirect()->route('cinema');
        }
    }

    public function showAddShow()
    {
        $movie=$this->movierepository->all();
       $cinema=$this->cinemarepository->all();
       
        return view('show_create',compact('movie','cinema'));
    }
    public function addShow(CinemaMovieRequest $request)
    {
       
        if($this->cinemarepository->addShowTime($request))
        {
            return redirect()->route('show');
        }
    }
    public function showEditShow($id,$my)
    {
        $movie=$this->movierepository->all();
       $cinema=$this->cinemarepository->all();
       $show=$this->cinemarepository->findByIdAndCinema($id,$my);
       return view('show_update',compact('show','movie','cinema'));
    }
    public function updateShow(CinemaMovieRequest $request,$id,$myid)
    {
        if($this->cinemarepository->updateShowTime($id,$myid,$request))
        {
            return redirect()->route('show');
        }
    }
    public function deleteShow(CinemaMovieRequest $request,$id,$myid)
    {
        if($this->cinemarepository->deleteShowTime($id,$myid))
        {
            return redirect('/');
        }
    }
}
