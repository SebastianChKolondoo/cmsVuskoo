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

    /* public function getBlogList($categoria = null, $id = null)
    {
        $query = DB::connection('mysql_second')->table('wp_posts')
            ->select(
                'wp_yoast_indexable.open_graph_image as imagen',
                'wp_terms.slug as term_slug',
                'wp_terms.name as term_categoria',
                'wp_posts.post_date as fecha_publicacion',
                'wp_posts.post_title as titulo',
                'wp_posts.post_content as contenido',
                'wp_posts.post_excerpt as entradilla',
                'wp_yoast_indexable.title as seo_titulo',
                'wp_yoast_indexable.description as seo_descripcion',
                'wp_yoast_indexable.breadcrumb_title as migapan',
                'wp_yoast_indexable.estimated_reading_time_minutes as tiempo_lectura',
                'wp_posts.post_name as url_amigable',
                'wp_users.display_name as autor',
                'wp_postmeta.meta_value as categoriaPrincipal',
                'principal.slug as categoria_slug',
                'principal.name as categoria',

            )
            ->join('wp_yoast_indexable', 'wp_yoast_indexable.object_id', '=', 'wp_posts.ID')
            ->join('wp_users', 'wp_users.ID', '=', 'wp_posts.post_author')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->join('wp_postmeta', 'wp_postmeta.post_id', '=', 'wp_posts.ID')
            ->join('wp_terms as principal', 'principal.term_id', '=', 'wp_postmeta.meta_value')

            ->where('wp_postmeta.meta_key', '=', '_yoast_wpseo_primary_category')
            ->where('wp_posts.post_status', '=', 'publish')
            ->where('wp_posts.post_type', '=', 'post')
            ->where('wp_yoast_indexable.object_type', '=', 'post')
            ->where('wp_yoast_indexable.object_sub_type', '=', 'post')
            ->where('wp_yoast_indexable.post_status', '=', 'publish')
            ->where('wp_term_taxonomy.taxonomy', '=', 'category')
            ->orderBy('wp_posts.ID', 'desc');

        // Optional condition based on the variable
        if ($id) {
            $query->where('wp_posts.post_name', '=', $id);
        }
        if ($categoria && $id == null) {
            $query->where('wp_terms.slug', '=', $categoria);
        }
        if ($categoria !== 'destacado') {
            $query->where('wp_terms.slug', '!=', 'destacado');
        }

        return $query->get();
    }
 */
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

    public function getBlogHomeList()
    {

        return DB::connection('mysql_second')->table('wp_posts')
            ->select(
                'wp_yoast_indexable.open_graph_image as imagen',
                'wp_posts.post_date as fecha_publicacion',
                'wp_posts.post_title as titulo',
                'wp_posts.post_content as contenido',
                'wp_posts.post_excerpt as entradilla',
                'wp_yoast_indexable.title as seo_titulo',
                'wp_yoast_indexable.description as seo_descripcion',
                'wp_yoast_indexable.breadcrumb_title as migapan',
                'wp_yoast_indexable.estimated_reading_time_minutes as tiempo_lectura',
                'wp_posts.post_name as url_amigable',
                'wp_users.display_name as autor',
                'wp_postmeta.meta_value as categoriaPrincipal',
                'principal.slug as categoria_slug',
                'principal.name as categoria'
            )
            ->join('wp_yoast_indexable', 'wp_yoast_indexable.object_id', '=', 'wp_posts.ID')
            ->join('wp_users', 'wp_users.ID', '=', 'wp_posts.post_author')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->join('wp_postmeta', 'wp_postmeta.post_id', '=', 'wp_posts.ID')
            ->join('wp_terms as principal', 'principal.term_id', '=', 'wp_postmeta.meta_value')

            ->where('wp_postmeta.meta_key', '=', '_yoast_wpseo_primary_category')
            ->where('wp_posts.post_type', '=', 'post')
            ->where('wp_yoast_indexable.object_type', '=', 'post')
            ->where('wp_yoast_indexable.object_sub_type', '=', 'post')
            ->where('wp_term_taxonomy.taxonomy', '=', 'category')
            ->where('wp_posts.post_status', '=', 'publish')
            ->where('wp_yoast_indexable.post_status', '=', 'publish')
            ->where('wp_terms.slug', '!=', 'destacado')
            ->orderBy('wp_posts.ID', 'desc')
            ->limit(3)->get();
    }

    public function getBlogId($id)
    {
        return DB::table('SEO_BLOG')->select('SEO_BLOG.metatitulo as seo_titulo', 'SEO_BLOG.metadescripcion as seo_descripcion', 'blog.*', 'categorias.*', 'blog.entradilla as entrada')->leftJoin('blog', 'blog.SEO_id', 'SEO_BLOG.id')->leftJoin('categorias', 'blog.categoria_id', 'categorias.id')->where('SEO_BLOG.url_amigable', '=', $id)->get();
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
