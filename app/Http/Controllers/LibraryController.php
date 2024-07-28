<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Member;
use App\Models\Record;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use File;
use Response;

class LibraryController extends Controller
{
  public function out(){
    Auth::logout();
    return redirect('/login');
  }

 public function home() {
    return view('home',['title' => 'Home']);
  }

  public function dashboard() {
    return view('admindashboard',['title' => 'Admin Dashboard']);
  }
 public function bookCategories(){
    $categories = Category::all();
    return view('book_categories',['title' => 'Books Categories','data' => $categories]);
  }
  public function categories(){
    $categories = Category::all();
    return view('categories',['title' => 'Books Categories','data' => $categories]);
  }
  public function books($category){
    $books = Book::where('category',$category)->orderBy('book_id', 'ASC')->get();
    $cat = Category::find($category);
    return view('user_books',['title' => $cat->name,'data' => $books,'category' => $category]);
  }
  public function search(){
    // $books = Book::select('books.*','categories.name as category_name')->leftJoin('categories','books.category','categories.id')->orderBy('books.id', 'DESC')->get();
    return view('search',['title' => 'Search']);
  }
  public function loadBook(Request $request){
  
    if(isset($request->value)){
      if(isset($request->category)){
        $books = Book::select('books.*','categories.name as category_name')->leftJoin('categories','books.category','categories.id')
        ->where('books.category',$request->category)->where('books.name','LIKE',"%$request->value%")
        ->orderBy('books.id', 'DESC')->get();
      }
      else{
        $books = Book::select('books.*','categories.name as category_name')->leftJoin('categories','books.category','categories.id')->where('books.name','LIKE',"%$request->value%")
        ->orderBy('books.id', 'DESC')->get();
      }
      
    }
    else{
      if(isset($request->category)){
        $books = Book::select('books.*','categories.name as category_name')->leftJoin('categories','books.category','categories.id')->where('books.category',$request->category)->orderBy('books.id', 'DESC')->get();
      }
      else {
        $books = Book::select('books.*','categories.name as category_name')->leftJoin('categories','books.category','categories.id')->orderBy('books.id', 'DESC')->get();
      }
    }
    $count = $books->count();
    return response()->json([
      'success' => true,
      'count'  => $count,
      'data' => $books,
     ]);
  }
  public function booklist($category){
    $books = Book::where('category',$category)->orderBy('book_id', 'ASC')->get();
    $cat = Category::find($category);
    return view('books',['title' => $cat->name,'data' => $books,'category' => $category]);
  }
  public function download($category){
    $books = Book::where('category',$category)->orderBy('book_id', 'ASC')->get();  
       $headers = array(
          'Content-Type' => 'text/csv',
         'charset'=> 'UTF-8'
        );
         if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }
           $filename =  public_path("files/download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
"Id",
            "Name",
            "Author",
        ]);
         foreach ($books as $book) {
            fputcsv($handle, [
$book->book_id,
               $book->name,
               $book->author
            ]);

        }
        fclose($handle);

        //download command
        return Response::download($filename, "download.csv", $headers);
  }
  public function addBook(){
    $categories = Category::all();
    return view('addbook',['title' => 'Add Book','categories' => $categories]);
  }

  public function saveBook(Request $request){
    $id = $request->book_id;
    $bookExists = Book::where('book_id', '=', $id)->first();
  
    if ($bookExists){
       return response()->json([
        'success' => false,
    ]);
    }
    else{
      $table = new Book;
      $table->book_id = $request->book_id;
      $table->name = $request->name;
      $table->author = $request->author;
      $table->category = $request->category;
      $table->save();
      return response()->json([
        'success' => true,
    ]);
    }
    
  }

  public function updateBook(Request $request){
    $id = $request->id;
    $table = Book::find($id);
    $table->book_id = $request->book_id;
    $table->name = $request->name;
    $table->author = $request->author;
    $table->category = $request->category;
    $table->save();
    return response()->json([
      'success' => true,
    ]);
    
    
  }

  public function editBook($id) {
    $book = Book::findOrFail($id);
     $categories = Category::all();
    return view('editbook', ['title' => 'Edit Book','data'=> $book,'categories' => $categories]);

 }

  public function deleteBook($id) {
    $book = Book::findOrFail($id);
    $book->delete();
    return redirect('/books');

  }

  public function memberlist(){
    $members = Member::all();
    return view('members',['title' => 'Members List','data' => $members]);
  }

  public function addMember(){
    return view('addmember',['title' => 'Add Member']);
  }

  public function saveMember(Request $request){
    $id = $request->member_id;
    $bookExists = Member::where('member_id', '=', $id)->first();
  
    if ($bookExists){
       return response()->json([
        'success' => false,
    ]);
    }
    else{
      $table = new Member;
      $table->member_id = $request->member_id;
      $table->name = $request->name;
      $table->place = $request->place;
      $table->batch = $request->batch ?? NULL;
      $table->save();
      return response()->json([
        'success' => true,
    ]);
    }
    
  }

  public function updateMember(Request $request){
    $id = $request->id;
    $table = Member::find($id);
    $table->member_id = $request->member_id;
    $table->name = $request->name;
    $table->place = $request->place;
    $table->batch = $request->batch ?? NULL;
    $table->save();
    return response()->json([
      'success' => true,
    ]);
    
    
  }

  public function editMember($id) {
    $member = Member::findOrFail($id);
    return view('editmember', ['title' => 'Edit Member','data'=> $member]);

 }

  public function deleteMember($id) {
    $member = Member::findOrFail($id);
    $member->delete();
    return redirect('/members');

  }

  public function record($type){
    // $type = 'ml';
    $member = Member::all();
    if($type == 'ml'){
      $book = Book::where('status', '=', 1)->whereNotIn('category', ['25','26','27'])->get();
    }
    elseif($type == 'en'){
      $book = Book::where('status', '=', 1)->whereIn('category', ['25','26','27'])->get();
    }
    elseif($type == 'research') {
      $book = Book::where('status', '=', 1)->get();
    }

    return view('record', ['title' => 'New Records','members' => $member,'books' => $book ,'type' => $type]);
  }

  public function getMember(Request $request, $type){
    $id = $request->id;
    $member = Member::find($id);
    if($type == 'ml'){
      $records = DB::table('records')
      ->join('books', 'records.book_id', '=', 'books.id')
      ->select('records.*', 'books.name AS book')
      ->where('records.member_id',$id)
      ->whereNotIn('books.category', ['25','26','27'])
      ->orderBy('id', 'DESC')
      ->where('records.type',1)
      ->limit(1)
      ->get();
    }
    elseif($type == 'en'){
      $records = DB::table('records')
      ->join('books', 'records.book_id', '=', 'books.id')
      ->select('records.*', 'books.name AS book')
      ->where('records.member_id',$id)
      ->whereIn('books.category',['25','26','27'])
      ->orderBy('id', 'DESC')
      ->where('records.type',1)
      ->limit(1)
      ->get();
    }
    elseif($type == 'research'){
      $records = DB::table('records')
      ->join('books', 'records.book_id', '=', 'books.id')
      ->select('records.*', 'books.name AS book')
      ->where('records.member_id',$id)
      ->where('records.type',2)
      ->where('records.status',0)
      ->orderBy('id', 'DESC')
      ->get();
    }
   if($records){
    foreach($records as $record){
      $record->created_at = date('d-m-Y', strtotime($record->created_at));
      $record->updated_at = date('d-m-Y', strtotime($record->updated_at));
    }
   }
 
    return response()->json([
      'name' => $member->name,
      'place' => $member->place,
      'batch' => $member->batch,
      'record' => $records,
    ]);
  }

  public function getBook(Request $request,$type){
    $id = $request->id;
    $book = Book::find($id);
    return response()->json([
      'name' => $book->name,
      'author' => $book->author,
      'category' => $book->category,
    ]);
  }

  public function saveRecord(Request $request,$type){

    $book = Book::find($request->book);
    $book->status = 0;
    $book->save();
    $table = new Record;
    $table->member_id = $request->member;
    $table->book_id = $request->book;
    if($type == 'research'){
      $table->type = 2;
    }
    $table->save();
    return response()->json([
      'success' => true,
  ]);
    
    
  }

  public function closeRecord(Request $request,$type) {
    $record = Record::find($request->id);
    $record->status = 1;
    $record->update();
    $book = Book::find($record->book_id);
    $book->status= 1;
    $book ->update();
    $member = Member::find($record->member_id);
    $fine = $member->fine + $request->fine;
    $member->fine = $fine;
    $member->update();
    return true;
  }

  public function renewRecord(Request $request,$type) {
    $record = Record::find($request->id);
    $record->status = 1;
    $record->update();
    $member = Member::find($record->member_id);
    $fine = $member->fine + $request->fine;
    $member->fine = $fine;
    $member->update();
    $new = new Record;
    $new->member_id = $record->member_id;
    $new->book_id = $record->book_id;
    $new->save();
    return true;
  }

  public function recordBook($id){
    $book = Book::find($id);
    $records = DB::table('records')
    ->join('members', 'records.member_id', '=', 'members.id')
    ->select('records.*', 'members.name AS member','members.place AS place','members.batch AS batch')
    ->where('records.book_id',$book->id)
    ->orderBy('id', 'DESC')
    ->get();
    foreach($records as $record){
      $record->created_at = date('d-m-Y', strtotime($record->created_at));
      $record->updated_at = date('d-m-Y', strtotime($record->updated_at));
    }
  
    return view('recordbook', ['title' => $book->name,'records' => $records]);
  }

  public function recordMember($id){
    $member = Member::find($id);
    $records = DB::table('records')
    ->join('books', 'records.book_id', '=', 'books.id')
    ->select('records.*', 'books.name AS book','books.author AS author','books.category AS category')
    ->where('records.member_id',$member->id)
    ->orderBy('id', 'DESC')
    ->get();
    foreach($records as $record){
      $record->created_at = date('d-m-Y', strtotime($record->created_at));
      $record->updated_at = date('d-m-Y', strtotime($record->updated_at));
    }
  
    return view('recordmember', ['title' => $member->name,'records' => $records]);
  }

}
