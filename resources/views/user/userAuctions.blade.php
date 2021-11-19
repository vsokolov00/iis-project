@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Vytvořené aukce</h1>
		<table class="table table-striped table-display-lg ">
			<thead>
				<tr>
					<th scope="col">Název</th>
					<th scope="col" class="text-center">Schválená</th>
					<th scope="col">Typ aukce</th>
					<th scope="col">Začátek aukce</th>
					<th scope="col" class="text-right">Počáteční cena</th>
					<th scope="col" class="text-right">Konečná cena</th>
				</tr>
			</thead>
			<tbody>
                <?php $imagePath = "storage/images/"; ?>
				@foreach ($auctions as $auction)
                        <tr onclick="openModal('{{ asset($imagePath . $auction->auctionItem->image); }}', '{{ $auction->auctionItem->item_name }}', '{{ $auction->auctionItem->description }}',
                        '{{ $auction->starting_price }}', '-1', '-1', '{{ $auction->start_time }}', '{{ $auction->time_limit }}', '{{ $auction->is_open  }}', '{{ $auction->is_selling }}')">
                            <td>{{$auction->auctionItem->item_name}}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @if($auction->is_approved)
                                        <span class="material-icons-outlined green-text md-36">check</span>
                                    @else
                                        <span class="material-icons-outlined yellow-text md-36">watch_later</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                    @if($auction->is_selling)
                                        <div class="auctionTypeLabel label-yellow">Prodej</div>
                                    @else
                                        <div class="auctionTypeLabel label-green">Nákup</div>
                                    @endif
                            </td>
                            <td>
                                    {{date("j. n. Y H:i", strtotime($auction->start_time))}}
                            </td>
                            <td class="text-right">
                                {{number_format($auction->starting_price,0,"", " ")}} Kč
                            </td>
                            @if($auction->closing_price == null)
                                <td class="text-center">-</td>
                            @else
                                <td class="text-right">
                                        {{number_format($auction->closing_price ,0 ,"", " ")}}	Kč
                                </td>
                            @endif
                        </tr>
				@endforeach
				</tbody>
			</table>

			<table class="table table-striped table-display-sm" >
				<tbody>
					@foreach ($auctions as $auction)
                        <tr>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#editModal"
                                    data-img="{{ $auction->auctionItem->image }}"
                                    data-name="{{ $auction->auctionItem->item_name }}"
                                    data-description="{{ $auction->auctionItem->description }}"
                                    data-sprice="{{ $auction->starting_price }}"
                                    data-minbid="-1"
                                    data-maxbid="-1"
                                    data-stime="{{ $auction->start_time }}"
                                    data-etime="-1"
                                    data-isopen="{{ $auction->is_open  }}"
                                    data-issell="{{ $auction->is_selling }}">
                                    <table class="table-plain">
                                    <tbody>
                                        <tr>
                                        <th scope="row">Název</th>
                                        <td>{{$auction->auctionItem->item_name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Schválená</th>
                                            <td>
                                                    @if($auction->is_approved)
                                                        <span class="material-icons-outlined green-text md-36">check</span>
                                                    @else
                                                        <span class="material-icons-outlined yellow-text md-36">watch_later</span>
                                                    @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Typ aukce</th>
                                            <td>
                                                @if($auction->is_selling)
                                                    <div class="auctionTypeLabel label-yellow">Prodej</div>
                                                @else
                                                    <div class="auctionTypeLabel label-green">Nákup</div>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Začátek aukce</th>
                                            <td>
                                                {{date("j. n. Y H:i", strtotime($auction->start_time))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Počáteční cena</th>
                                            <td>{{number_format($auction->starting_price,0,"", " ")}} Kč</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Konečná cena</th>
                                            @if($auction->closing_price == null)
                                                <td class="text-center">-</td>
                                            @else
                                                <td class="text-right">
                                                        {{number_format($auction->closing_price ,0 ,"", " ")}}	Kč
                                                </td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </a>
                            </td>
                        </tr>
					@endforeach
			</tbody>
		</table>
	</div>
    @component('components/edit-auction')
    @endcomponent
@endsection
