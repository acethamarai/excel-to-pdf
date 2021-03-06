@extends('layouts.master')
@section('content')
<div class='row'>
  <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Imported Data Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<?php //print_r($bat_info); exit; ?>
			<table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Batch No.</th>
                  <th>Generated Date</th>
                  <th>Generated By</th>
                  <th>Data Count</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				@foreach( $bat_info as $val )
				<?php
				$tmp = explode('/', $val['gen_date']);
				$date = $tmp[2] . '/' . $tmp[1] . '/' . $tmp[0];
				?>
				<tr>
                  <td>{{ $val['id'] }}</td>
				  <td>{{ $date }}</td>
                  <td>{{ $val['name'] }}</td>
                  <td><span class="label pull-right bg-green">{{ $val['tcount'] }}</span></td>
                  <td>@if($val['status']==1) {{'Success'}} @else {{'Deleted'}} @endif</td>
                  <td>@if($val['status']==1) <a href="{{ route('batch', ['batch_id' => $val['id']]) }}" class="btn btn-info">View</a> <a href="javascript:IsDelete({{$val['id']}})" class="btn btn-warning">Delete</a>@endif</td>
                </tr>
                @endforeach
                </tbody>
              </table>
			</div><!-- /.box-body -->
			</div><!-- /.box -->
      </div>
</div><!-- /.row -->
<script>
function IsDelete(bid)
{		
	if (bid == ""){
		        //  return false;
		}
		else
		{
		var r = confirm("Are you sure to Delete Batch ?");
		    if (r == true)
			{
			location.href = '{{url('deletebatch')}}/' + bid;
			}
		}
		
}
</script>
@endsection