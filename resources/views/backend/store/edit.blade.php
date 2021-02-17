@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Store</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('stores.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Stores</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Store</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('stores.update',$store->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store Name <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" placeholder="Name" name="name" value="{{$store->name}}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store Phone <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" placeholder="Phone" name="phone" value="{{$store->phone}}">
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store Email <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="email" name="email" value="{{$store->email}}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store Address <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" type="text" placeholder="Address" name="address" value="{{$store->address}}">
                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store Website <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" type="text" placeholder="Url" name="website" value="{{$store->website}}">
                                @if ($errors->has('website'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right"> Facebook Page Link <span style="color: red">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control{{ $errors->has('page') ? ' is-invalid' : '' }}" type="text" placeholder="page link" name="page" value="{{$store->page}}">
                                @if ($errors->has('page'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('page') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Store Logo</label>
                            <div class="col-md-8">
                                <input class="{{ $errors->has('logo') ? ' is-invalid' : '' }}" type="file"  name="logo">
                                @if ($errors->has('logo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                                <br/>
                                <img src="{{asset('uploads/store/'.$store->logo)}}" height="60px" width="250px"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Store</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
@endsection


