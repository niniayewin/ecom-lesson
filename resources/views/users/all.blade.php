@extends('layouts.app')
@section('title')User @stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                @include('partical.menu')
            </div>
            <div class="col-sm-9">
                <div><i class="fas fa-users-cog"></i> Users</div>
                <div class="dropdown-divider"></div>
                <div class="row">
                <table class="table table-borderless table-hover">
                    <tr class="bg-info">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Join Date</th>
                        <th>Actions</th>
                    </tr>

                    @foreach($users as $u)
                        <tr>
                            <td>{{$u->name}}</td>
                            <td>{{$u->email}}</td>
                            <td>
                                @if($u->hasAnyRole(['Admin']))
                                    {{$u->roles()->first()->name}}
                                    @else
                                    Role not found
                                @endif
                            </td>
                            <td>{{$u->created_at->diffForHumans()}}</td>
                            <td>
                                 <a  data-toggle="modal" data-target="#r{{$u->id}}" href="#" class="btn btn-outline-info btn-lg">
                                     <span data-toggle="tooltip" data-placement="top" title="Assign User Role">
                                     <i class="fas fa-users-cog"></i>
                                     </span>
                                 </a>
                                <!-- select for user permission-->
                                <div id="r{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <form action="{{route('assign.user.role')}}" method="post">
                                            <input type="hidden" name="user_id" value="{{$u->id}}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Select Permission</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="role"> Role</label>
                                                        <select class="custom-select" name="role" id="role">
                                                            @foreach($role as $r)
                                                                <option>{{$r->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--End select for user permission-->
                                 <a  data-toggle="modal" data-target="#e{{$u->id}}" href="#" class="btn btn-outline-primary btn-lg"><i class="fas fa-user-edit"></i></a>
                                <div  id="e{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <form method="post" action="{{route('update.user')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$u->id}}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Category Name</label>
                                                        <input type="text" name="name" id="name" class="form-control" value="{{$u->name}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" name="email" id="email" class="form-control" value="{{$u->email}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-outline-primary">Save Changed</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <a  data-toggle="modal" data-target="#d{{$u->id}}" href="" class="btn btn-outline-danger btn-lg"><i class="fas fa-user-times"></i></a>
                                <div  id="d{{$u->id}}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center text-warning">
                                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                                                <p>Are you sure?the category <b>"{{$u->name}}"</b> will be delected</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{route('post.drops',['id'=>$u->id])}}"> Agree</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
    @if (Session('info'))
        <div  class="alert alert-success my-alert"> {{Session('info')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>
    @endif
@stop






