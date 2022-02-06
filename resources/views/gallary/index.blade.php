@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Gallary</h2>
            </div>
            <div class="pull-right">
                @can('gallary-create')
                <a class="btn btn-success" href="{{ route('gallary.create') }}"> Create New Gallary</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Creation Time</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($gallary as $product)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $product->name }}</td>
	        <td>{{ $product->created_at }}</td>
	        <td>
                <form action="{{ route('gallary.destroy',$product->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('gallary.show',$product->id) }}">Show</a>
                    @can('gallary-edit')
                    <a class="btn btn-primary" href="{{ route('gallary.edit',$product->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('gallary-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $gallary->links() !!}



@endsection