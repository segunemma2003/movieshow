<?php

namespace App\Http\Controllers;
use App\Repositories\MovieRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;

class MovieController extends Controller
{
    private $movierepository;

    public function __construct(MovieRepositoryInterface $movierepository)
    {
        $this->movierepository=$movierepository;
    }

    public function index()
    {
        $movies=$this->movierepository->all();
        return view('show',compact('movies'));
    }
    public function showCreateMovie()
    {
        return view('movie_create');
    }
    public function showEditMovie($id)
    {
        $movie=$this->movierepository->findById($id);
        return view('movie_update',compact('movie'));

    }

    public function createMovie(MovieRequest $request)
    {
        if($this->movierepository->add($request))
        {
            return redirect()->route('movie');
        }
    }
    public function updateMovie(MovieRequest $request,$id)
    {
        if($this->movierepository->update($id,$request))
        {
            return redirect()->route('movie');
        }
    }
    public function deleteMovie($id)
    {
        if($this->movierepository->delete($id))
        {
            return redirect()->route('movie');
        }
    }
}
