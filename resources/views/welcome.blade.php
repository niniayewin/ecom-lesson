@extends('layouts.app')
@section('title')Welcome @stop
@section('content')
    @include('partical.slide')
    <div class="container-fluid mt-3">
        <div class="row">
           <div class="col-sm-3">
               <div class="card shadow mb-2">
                  <div class="card-header"> Shopping Cart</div>
                   <div class="card-body">
                       <p>
                           <a href="{{route('shopping.cart')}}">
                             <span class="badge badge-info">
                                 <i class="fas fa-shopping-basket"></i> &nbsp;
                                 {{Session::has('cart') ? Session::get('cart')->totalQty : "0"}}
                             </span>  Items
                           </a>
                       </p>
                   </div>
               </div>
              <div class="card shadow mb-2">
                   <div class="card-header">Search</div>
                   <div class="card-body">
                       <form action="{{route('post.search')}}" method="get">
                           <div class="form-group">
                            <input type="search" class="form-control" required name="q">
                           </div>
                       </form>
                   </div>
               </div>
               <div class="card shadow">
                  <div class="card-header">
                      <i class="fas fa-clipboard-list"></i> Categories
                  </div>
                   <div class="card-body">
                       <table class="table table-hover table-borderless">
                           @foreach($cats as $c)
                               <tr>
                                   <td>
                                       <a class="d-block" href="{{route('post.by.category',['post_id'=>$c->id])}}">{{$c->cat_name}}</a>
                                   </td>
                               </tr>
                           @endforeach
                       </table>
                   </div>
               </div>
           </div>
            <div class="col-sm-9">
                <div class="row">
                    @foreach($post as $p)
                        <div class="col-sm-4" data-toggle="tooltip" data-placement="top" title="{{$p->description}}">
                            <div class="card shadow mb-3">
                                <img src="{{route('images',['file_name'=>$p->image])}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{$p->item_name}}</h5>
                                    <p class="card-text">
                                        <span class="badge badge-info">$ {{$p->price}}</span>
                                    </p>
                                    <p class="card-text">
                                        <small><i class="fas fa-tag"></i> {{$p->post->cat_name}}</small>
                                          &nbsp;


                                        <small><i class="fas fa-calendar-day"></i> {{date("D(d) m/Y",strtotime($p->created_at))}}</small>
                                    </p>
                                    <a href="{{route('add.to.cart',['id'=>$p->id])}}" class="btn btn-outline-primary btn-block"><i class="fas fa-shopping-cart"></i> Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{$post->links()}}
            </div>
        </div>
    </div>
    <div class="card bg-secondary mt-5">
        <div class="card-body">
            <p class="text-center text-white-50">&copy; 2019 my..co,ltd</p>
            <div class="dropdown-divider">
            </div>
        </div>
    </div>
   @stop