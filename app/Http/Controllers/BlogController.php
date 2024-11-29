<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoriaBlog;
use App\Models\Categorias_blog;
use App\Models\Paises;
use App\Models\States;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;
use Mockery\Exception;

class BlogController extends Controller
{
    public function getMenuBlogList($lang = null)
    {
        return DB::connection('mysql_second')->table('wp_term_taxonomy')->select('wp_terms.name', 'wp_terms.slug')->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')->where('taxonomy', "category")->get();
    }

    public function getBlogNewList($lang = 'es')
    {
        $paises = Paises::where('codigo', $lang)->first();
        return Blog::select(
            'blog.id',
            'blog.url_amigable as url_amigable',
            'blog.imagen',
            'blog.fecha_publicacion',
            'blog.titulo',
            'blog.entradilla',
            'blog.categoria',
            'categorias_blog.id',
            'categorias_blog.nombre as categoria',
            'categorias_blog.slug as categoria_slug'
        )
            ->join('categorias_blog', 'categoria', 'categorias_blog.id')
            ->where('pais', $paises->id)
            ->orderBy('blog.id','desc')
            ->get();
    }

    public function getBlogItemList($lang = 'es', $categoria = null, $amigable = null)
    {
        $paises = Paises::where('codigo', $lang)->first();
        $categoria = CategoriaBlog::where('slug', strtolower($categoria))->first();
        $blog = Blog::select('id')
            ->where('categoria', $categoria->id);
        if ($amigable != null) {
            $blog->where('url_amigable', strtolower($amigable));
        }
        if ($blog->count() == 0) {
            return ['mensaje' => 'El blog no existe', 'error' => 404];
        } else {
            $data = Blog::select(
                'blog.id',
                'blog.entradilla',
                'blog.categoria',
                'categorias_blog.id',
                'blog.imagen',
                'blog.url_amigable as url_amigable',
                'blog.fecha_publicacion',
                'blog.titulo',
                'blog.contenido',
                'categorias_blog.nombre as categoria',
                'categorias_blog.slug as categoria_slug',
                'blog.url_amigable as url_amigable'
            )
                ->join('categorias_blog', 'categoria', 'categorias_blog.id')
                ->where('categoria', $categoria->id);

            if ($amigable != null) {
                $data->where('url_amigable', strtolower($amigable));
            }

            return $data->get();
        }
    }

    public function getBlogPreviewList($id)
    {
        return Blog::select(
            'blog.id',
            'blog.entradilla',
            'blog.categoria',
            'categorias_blog.id',
            'blog.imagen',
            'blog.url_amigable as url_amigable',
            'blog.fecha_publicacion',
            'blog.titulo',
            'blog.contenido',
            'categorias_blog.nombre as categoria',
            'categorias_blog.slug as categoria_slug',
            'blog.url_amigable as url_amigable'
        )
            ->join('categorias_blog', 'categoria', 'categorias_blog.id')
            ->where('blog.id', $id)->get();
    }

    /* Nuevo blog */

    function index()
    {
        $data = Blog::all();
        return view('blog.index', compact('data'));
    }

    function edit($id)
    {
        $data = Blog::find($id);
        $paises = Paises::all();
        $categorias = CategoriaBlog::all();
        $states = States::all();
        return view('blog.edit', compact('data', 'paises', 'categorias', 'states'));
    }

    function create()
    {
        $paises = Paises::all();
        $states = States::all();
        $categorias = CategoriaBlog::all();
        return view('blog.create', compact('paises', 'categorias','states'));
    }


    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $data = $request->all();
        $urlImagen = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = 'banner_blog_' . $id . '.' . $extension;
            $path = Storage::disk('public')->putFileAs('blog', $file, $nombreArchivo);
            $urlImagen = 'https://cms.vuskoo.com/storage/blog/'.$nombreArchivo;
        }

        // Crear un array de datos a actualizar
        if ($urlImagen) {
            $data['imagen'] = $urlImagen;
        }

        $blog->update($data);
        return back()->with('info', 'Blog actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $urlImagen = null;


        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = 'banner_blog_' . time() . '.' . $extension;
            $path = Storage::disk('public')->putFileAs('blog', $file, $nombreArchivo);
            $urlImagen = 'https://cms.vuskoo.com/storage/blog/'.$nombreArchivo;
        }

        $data = Blog::create([
            'imagen' => $urlImagen,
            'fecha_publicacion' => now(),
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'entradilla' => $request->entradilla,
            'seo_titulo' => $request->seo_titulo,
            'seo_descripcion' => $request->seo_descripcion,
            'migapan' => $request->migapan,
            'url_amigable' => $request->url_amigable,
            'categoria' => $request->categoria,
            'pais' => $request->pais,
            'destacada' => $request->destacada,
            'estado' => $request->estado,
        ]);


        return redirect()->route('blog.index')->with('info', 'Entrada de blog creada correctamente.');
    }

    public function blogPreview($id)
    {
        $data = Blog::find($id);
        return view('blog.preview', compact('data'));
    }

    public function getBlogInfoCategoriaList($categoria)
    {
        $categoriaCount = CategoriaBlog::where('slug', strtolower($categoria))->count();
        if ($categoriaCount != 0) {
            $data = CategoriaBlog::where('slug', strtolower($categoria))->first();
            $blog = Blog::select('id')->where('categoria', $data->id)->count();
            if ($blog != 0) {
                return Blog::select('blog.imagen', 'blog.fecha_publicacion', 'blog.titulo', 'blog.contenido', 'categorias_blog.nombre as categoria', 'categorias_blog.slug as categoria_slug')->join('categorias_blog', 'categoria', 'categorias_blog.id')->where('categoria', $data->id)->get();
            } else {
                return ['mensaje' => 'La categoria no tiene blogs', 'error' => 404];
            }
        } else {
            return ['mensaje' => 'La categoria no tiene blogs', 'error' => 404];
        }
    }

    public function getBlogInfoHomeList($lang = 'es')
    {
        $pais = Paises::where('codigo', $lang)->first();
        return Blog::select('blog.imagen','blog.url_amigable', 'blog.fecha_publicacion', 'blog.titulo', 'blog.contenido', 'categorias_blog.nombre as categoria', 'categorias_blog.slug as categoria_slug')
        ->join('categorias_blog', 'categoria', 'categorias_blog.id')
        ->where('pais', $pais->id)
        ->orderBy('blog.fecha_publicacion', 'desc')
        ->limit(3)->get();
    }

    public function getMenuInfoBlogList($lang)
    {
        $pais = Paises::where('codigo', $lang)->first();
        return $blog = Blog::select('categorias_blog.nombre','blog.url_amigable', 'categorias_blog.slug', 'blog.categoria')
        ->groupBy('categoria')
        ->where('pais', $pais->id)
        ->join('categorias_blog', 'categorias_blog.id', 'blog.categoria')
        ->get();
    }
}
