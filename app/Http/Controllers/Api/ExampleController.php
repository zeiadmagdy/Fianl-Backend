<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function triggerError()
    {
        // This will throw a generic server error
        abort(500);
    }
}
