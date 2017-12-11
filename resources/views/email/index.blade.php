@extends('beautymail::templates.minty')

@section('content')

	@include('beautymail::templates.minty.contentStart')
		<tr>
			<td class="title">
				Selamat Datang
			</td>
		</tr>
		<tr>
			<td width="100%" height="10"></td>
		</tr>
		<tr>
			<td class="paragraph">
				{{-- This is a paragraph text --}}
			</td>
		</tr>
		<tr>
			<td width="100%" height="25"></td>
		</tr>
		<tr>
			<td class="title">
				Notifikasi Aplikasi HRD PT. SAMUDRA MAJU PERKASA
			</td>
		</tr>
		<tr>
			<td width="100%" height="10"></td>
		</tr>
		<tr>
			<td class="paragraph">
				<h3>{{$pesan}}</h3>
				<h3>{{$nominal}}</h3>
			</td>
		</tr>
		<tr>
			<td width="100%" height="25"></td>
		</tr>
		<tr>
			<td>
				{{-- @include('beautymail::templates.minty.button', ['text' => 'Sign in', 'link' => '#']) --}}
			</td>
		</tr>
		<tr>
			<td width="100%" height="25"></td>
		</tr>
	@include('beautymail::templates.minty.contentEnd')

@stop
