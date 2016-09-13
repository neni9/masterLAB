<?php

namespace App\Http\Controllers;

use File;
use View;
use App\Post;
use App\Picture;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Traits\TraitTwitter;
use Illuminate\Cookie\CookieJar;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    use TraitTwitter;

    /**
     * $paginate (10 posts by pages)
     * 
     * @var integer
     */
    private $paginate = 25;

    /**
     * $sortBy default 
     * 
     * @var string
     */
    private $sortBy   = 'published_at';

    /**
     * $sortDir default 
     * 
     * @var string
     */
    private $sortDir  = 'desc';
   
    /**
     * __construct 
     * 
     */
    public function __construct(){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CookieJar $cookie, Request $request)
    {
        $title                  = 'Liste des articles';
        $total                  = [];
        $total['published']     = Post::TotalStatus('published');
        $total['unpublished']   = Post::TotalStatus('unpublished');
        $data                   = $request->all();

        //Récupération SORTBY
        if(empty($request->cookie('elycee_posts_sortby')))
            $sortBy = $this->sortBy;
        else{
            if(!empty($data['sortBy'])) $sortBy  = $data['sortBy'];
            else                        $sortBy  = $request->cookie('elycee_posts_sortby');
        }

        //Récupération SORTDIR
        if(empty($request->cookie('elycee_posts_sortdir')))
            $sortDir = $this->sortDir;
        else{
            if(!empty($data['sortDir'])) $sortDir  = $data['sortDir'];
            else                         $sortDir  = $request->cookie('elycee_posts_sortdir');
        }

        //Récupération des posts
        $posts = Post::getPostsOrderBy($sortBy,$sortDir);

        //Maj Cookies SortBy & SortDir
        if(!empty($sortBy))   $cookie->queue(cookie('elycee_posts_sortby', $sortBy, 45000));
        if(!empty($sortDir))  $cookie->queue(cookie('elycee_posts_sortdir', $sortDir, 45000));
         
        return view('back.admin.articles.list',compact('title','posts','total','sortBy','sortDir'));
    }


    /**
     * Massupdate records - ACTIONS : Publier / Dépublier / Supprimer
     *
     * @return \Illuminate\Http\Response
     */
    public function postMassUpdate(Request $request)
    {
        $datas = $request->all();   

        if(empty($datas['massupdate']) || empty($datas['ids']) ) 
            return redirect('/admin/post')->with('message', 'Un problème est survenu dans la récupération des données.');

        //massupdate PUBLIER || DEPUBLIER
        if($datas['massupdate'] == 'published' || $datas['massupdate'] == 'unpublished'){

            $posts = Post::whereIn('id', $datas['ids'])->get();

            foreach ($posts as $post ) {
                
                if($post->status == 'Non Publié' && $datas['massupdate'] == 'published')
                    Post::publish($post);
                else if($post->status == 'Publié' && $datas['massupdate'] == 'unpublished')
                    Post::unpublish($post);
            }

            return redirect('/admin/post')->with('message', 'La mise à jour globale des articles a été effectuée avec succès.');
        }
        //massupdate SUPPRESSION
        else if($datas['massupdate'] == 'delete'){

            $delete = $this->destroyMany($datas['ids']); 

            return redirect('/admin/post')->with('message', sprintf("Les articles ont bien été supprimés."));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $ids
     * @return \Illuminate\Http\Response
     */
    public function destroyMany($ids)
    {
        if(!is_array($ids)) return;

        //Si image associée, la supprimer dans le dossier uploads
        $pictures = Picture::whereIn('post_id', $ids)->get();

        foreach ($pictures as $picture) 
            $this->destroyImage($picture->id);

        Post::whereIn('id', $ids)->delete();
        
        return true;
    }

    /**
     * Remove the specified resource from storage
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post    = Post::findOrFail($id);
        $picture = Picture::where('post_id', $id)->get()->first(); 

        if($picture)
            $this->destroyImage($picture->id);

        $post->delete();

        return redirect('/admin/post')->with('message', sprintf("L'article %s a été supprimé avec succès.",$post->title));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title      = "Ajouter un article";

        return view('back.admin.articles.createOrUpdate',compact('title'));
    }

     /**
     * upload Upload an image and attach it to a post
     * 
     * @param  file $im     
     * @param  string $name   
     * @param  int $postId 
     * @return picture object        
     */
    private function upload($im,$name,$postId)
    {    
        $ext = $im->getClientOriginalExtension();   
        $uri = str_random(50).'.'.$ext;     
        $picture = Picture::create([
            'name'    => $name,
            'uri'     => $uri, 
            'size'    => $im->getSize(),
            'mime'    => $im->getClientMimeType(),
            'post_id' => $postId
        ]);

        $im->move(env('UPLOAD_PICTURES','uploads'),$uri);

        return $picture;
    }

    /**
     * destroyImage from server
     * @param  int $pictureId 
     * @return boolean
     */
    public function destroyImage($pictureId)
    {
       if(is_null($pictureId) || !is_numeric($pictureId)) return;

        $pic = Picture::findOrFail($pictureId);

        if($pic){
            $fileName = public_path('uploads') . DIRECTORY_SEPARATOR . $pic->uri;

            if(File::exists($fileName)){
                File::delete($fileName);
                return true;
            }
        }

        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $datas      = Post::prepare($request->all());
        $post       = Post::create($datas);

        $messages   = [];

        if(!is_null($request->file('picture')))
            $picture = $this->upload($request->file('picture'), $request->input('picture_name'),$post->id);

        if($request->tweet == "on" && $request->status == 'published'){
            
            $content = empty($request->tweet_content) ? sprintf("Retrouvez un nouvel article sur notre site  : %s ",$request->title) : $request->tweet_content;
            $content .= sprintf(" %s/article/%d ",env('URL_SITE'),$post->id); 

            if($request->tweet_img == "on" && isset($picture))
                $this->setMediaTweet($content, public_path() . DIRECTORY_SEPARATOR . 'uploads/'. $picture->uri);
            else
                $this->setTweet($content); 
        }

        if($request->tweet == "on" && $request->status == 'unpublished') 
            $messages[] = "Le tweet n'a pas pu être posté car l'article n'est pas publié sur le site.";
      
        $messages[] = sprintf("L'article \"%s\" a été créé avec succès.",$request->title);

        return redirect('/admin/post/')->with('message', $messages);
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title      = 'Editer un article';
        $post       = Post::findOrFail($id);

        return view('back.admin.articles.createOrUpdate',compact('post','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        //En fonction du status la date de publication est changée
        if($post->status == 'Non Publié' && $request->status == 'published')
            $post->published_at = Carbon::now();

        if($post->status == 'Publié' && $request->status == 'unpublished')
            $post->published_at = null;

        //Update du post
        $post->update($request->all());

        //Cas Suppression de l'image
        if($request->input('deleteImage') == "on"){
            $this->destroyImage($post->picture->id);
            $post->picture->delete();
        }
        //Cas remplacement / ajout d'une image
        else if($request->file('picture')){
            if($post->picture) {
                $this->destroyImage($post->picture->id);
                $post->picture->delete();
            }
            $picture = $this->upload($request->file('picture'), $request->input('picture_name'),$post->id);
        }
        //Cas renommage de l'image
        else if(!$request->file('picture') && $post->picture && !empty($request->input('picture_name'))){
            $post->picture->update(['name' => $request->input('picture_name')]);
        }
        
        return redirect('/admin/post/')->with('message', sprintf("L'article a été mis à jour."));
    }
}