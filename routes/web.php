<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use \App\Models\Post;
use \App\Models\Project;
use \App\Models\ProjectSubcription;
use \App\Models\User;
use \App\Models\Career;
use \App\Models\Transaction;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;

Route::get('/', function () {
    $projects = Project::where('published', true)->orderBy('id', 'DESC')->limit(3)->get();
    $post = Post::where('status', true)->first();
    return view('welcome')->with(['projects' => $projects, 'post' => $post]);
});

Route::group(['middleware' => ['auth', 'verified']], function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Post Routes
    Route::prefix('/dashboard/posts')->group(function(){
        Route::get('/', function () {
            return view('backend.posts.posts')->with(['posts' => Post::all()]);
        })->name('posts');
        Route::get('/manage', function () {
            return view('backend.posts.manage')->with(['posts' => Post::all()]);
        })->name('posts.manage');
        Route::get('/new', function () {
            return view('backend.posts.new');
        })->name('posts.new');
        Route::get('/{id}/show', function ($id) {
            $id = Crypt::decrypt($id);
            if(!Post::find($id)) return redirect()->route('posts');
            return view('backend.posts.show')->with(['post' => Post::find($id)]);
        })->name('posts.show');
    });

    Route::prefix('/dashboard/career')->group(function(){
        Route::get('/', function () {
            return view('backend.careers.careers')->with(['careers' => Career::all()]);
        })->name('careers.career-list');
        Route::get('/new', function () {
            return view('backend.careers.new');
        })->name('careers.new');
        Route::get('/{id}/show', function ($id) {
            $id = Crypt::decrypt($id);
            if(!Post::find($id)) return redirect()->route('careers.career-list');
            return view('backend.careers.show')->with(['career' => Career::find($id)]);
        })->name('careers.show-career');
    });

    // Blog controller routes
    Route::prefix('/dashboard/')->group(function(){
        Route::resource('blogs', BlogController::class);
    });

    // Career routes
    Route::prefix('/dashboard/')->group(function(){
        Route::resource('careers', CareerController::class);
    });

    // Projects routs
    Route::prefix('/projects')->group(function(){
        // project terms and condition
        Route::get('/terms-and-conditions', function () {
            return view('backend.projects.terms-and-condition');
        })->name('projects.terms-conditions');
        // project index route
        Route::get('/', function () {
            return view('backend.projects.index');
        })->name('projects.index');
        // Personal project route
        Route::get('/personal', function () {
            return view('backend.projects.personal');
        })->name('projects.personal');
        // Manage project list
        Route::get('/manage', function () {
            return view('backend.projects.manage-projects');
        })->name('projects.manage');
        // register new project route
        Route::get('/register', function () {
            return view('backend.projects.register')->with(['projects' => Project::paginate(2)]);
        })->name('projects.register')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Create Project');
        // edit project route
        Route::get('/{id}/edit', function ($id) {
            $id = Crypt::decrypt($id);
            if(Project::find($id)) return view('backend.projects.edit')->with(['project' => Project::find($id)]);
            // return Redirect::back();
            return redirect()->route('projects.index');
        })->name('projects.edit')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Edit Project');
        // project details route
        Route::get('/{id}/details/', function ($id) {
            $id = Crypt::decrypt($id);
            if(Project::find($id)) return view('backend.projects.details')->with(['project' => Project::find($id)]);
            return redirect()->route('projects.manage');
        })->name('projects.details')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Read Project');
        // project subscription route
        Route::get('/{id}/subscribe/', function ($id) {
            $id = Crypt::decrypt($id);
            if(Project::find($id)) return view('backend.projects.subscribe')->with(['project' => Project::find($id)]);
            return redirect()->route('projects.index');
        })->name('projects.subscribe')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Create Subscription');

        // Project subscriptions route
        Route::get('/{id}/subscriptions/', function ($id) {
            $id = Crypt::decrypt($id);
            if(ProjectSubcription::where('project_id', $id)->first()) return view('backend.projects.project-subscriptions')->with(['project' => $id]);
            return redirect()->route('projects.manage');
        })->name('project.subscriptions')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Read Subscription');

        // Manage subscriptions route
        Route::get('/log-transaction/', function () {
            return view('backend.projects.log-transaction');
        })->name('projects.log.transaction')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Read Subscription|Manage Subscription');

        Route::get('/subscriptions/', function () {
            return view('backend.projects.manage-subscriptions');
        })->name('subscriptions.manage')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Read Subscription|Manage Subscription');

        // Manage subscriptions route
        Route::get('/payout/', function () {
            return view('backend.projects.manage-project-payouts');
        })->name('projects.manage.payouts')->middleware('role_or_permission:Adminstrator|Developer|Super Admin');

        // User investments route
        Route::get('/user-investments/{id}', function ($id) {
            $id = Crypt::decrypt($id);
            $user = User::find($id);
            if(User::find($id)) return view('backend.projects.my-investment')->with(['user' => $user]);
            return redirect()->route('projects.manage');
        })->name('projects.user-investment')->middleware('role_or_permission:Manage Subscription|Read Subscription|Adminstrator|Developer|Super Admin|'); 

        // Investment Details route
        Route::get('/investments/{user}/details/{id}', function ($user, $id) {
            $user = Crypt::decrypt($user);
            $id = Crypt::decrypt($id);
            if(ProjectSubcription::where('id', $id)->where('user_id', $user)->first()) return view('backend.projects.investment-details')->with(['subscription' => ProjectSubcription::where('id', $id)->where('user_id', $user)->first()]);
            return redirect()->route('projects.investment-details');
        })->name('projects.investment-details')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Manage Subscription|Read Subscription'); 
        
        // Manage Investors route
        Route::get('/investors/', function () {
            return view('backend.projects.investors');
        })->name('projects.investors')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Manage Subscription');

        // Manage Investors route
        Route::get('/transactions/', function () {
            return view('backend.projects.transactions');
        })->name('projects.transactions')->middleware('role_or_permission:Adminstrator|Developer|Super Admin');

        // Transaction Details route
        Route::get('/transaction/{id}/details/{type}', function ($id, $type) {
            $id = Crypt::decrypt($id);
            $type = Crypt::decrypt($type);
            return view('backend.projects.transaction-details')->with([
                'type' => $type, 'id' => $id
            ]);
        })->name('projects.transaction-details')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Read Transaction');

        // User transactions route
        Route::get('/user-transactions/{id}', function ($id) {
            $id = Crypt::decrypt($id);
            $user = User::find($id);
            if(User::find($id)) return view('backend.projects.user-transactions')->with(['user' => $user]);
            return redirect()->route('projects.manage');
        })->name('projects.user-transactions')->middleware('role_or_permission:Adminstrator|Developer|Super Admin|Read Transaction');
    });

    // Account management routes
    Route::prefix('/manage-account')->group(function(){
        // users list route
        Route::get('/', function () {
            return view('backend.accounts.users-list');
        })->name('accounts.users-list')->middleware('role_or_permission:Adminstrator|Developer|Super Admin');
        // users list route
        Route::get('/roles', function () {
            return view('backend.accounts.roles');
        })->name('accounts.roles')->middleware('role_or_permission:Developer|Super Admin');
        // users list route
        Route::get('/permissions', function () {
            return view('backend.accounts.permissions');
        })->name('accounts.permissions')->middleware('role_or_permission:Developer|Super Admin');
        // user profile route
        Route::get('/{id}/bio-profile', function ($id) {
            if(User::find(Crypt::decrypt($id))) return view('backend.accounts.user-profile')->with(['id' => Crypt::decrypt($id)]);
            return redirect()->route('accounts.users-list');
        })->name('accounts.user-bio-profile');
    });

    // Run symlink for storage
    Route::get('/create-storage', function(){
        // move to component
        $link = Artisan::call('storage:link', []);
        if($link) return redirect()->back();
        return false;
    })->name('storage.link');

    // Run Config Cache
    Route::get('/config-cache', function(){
        // php artisan config:cache
        $link = Artisan::call('config:cache', []);
        if($link) return redirect()->route('dashboard');
        return false;
    })->name('config.cache');
});

require __DIR__.'/auth.php';
