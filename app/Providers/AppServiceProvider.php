<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;


use File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') != 'local'){
            \URL::forceScheme('https');
        }

// Add in boot function
// DB::listen(function($query) {
//     File::append(
//         storage_path('/logs/query.log'),
//         '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
//     );
// });


        view()->composer('layouts.top-bar', function($view) {
            $data=DB::table('property_address')->select('property_id','state')
                ->groupBy('state')
                ->get();
            foreach ($data as $datum){
//      dd($datum);
                foreach ($datum as $row){
//          dd($datum);
                    $cities = DB::table('property_address')->where('state' , '=' , $datum->state)->pluck('city', 'property_id');
//      dd($cities);
                }
                $datum->city = $cities;
//      dd($datum);

            }
//            $data=DB::table('property_address')->select('id','state', 'city')
//                ->groupBy('state')
//                ->get();
//            $data=DB::table('property_address')->distinct(['state'])->get();

//            dd($data);
            $view->with('data', $data);
        });
        view()->composer('layouts.header', function($view) {
            $myvar=DB::table('blog')->get();
            $myvar2=DB::table('blog')->limit(4)->get();
            $mostPopularBlog=DB::table('blog')->orderBy('date_created' , 'desc')->limit(3)->get();
            $rest = [$myvar,$myvar2,$mostPopularBlog ];
            $view->with('data' , $rest);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
