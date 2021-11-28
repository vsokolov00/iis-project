@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="d-flex justify-content-end">
		    <h1 class="flex-1">Vytvořené aukce</h1>
            <a href="{{ route('newAuction') }}" class="add-button clickable rounded-circle d-flex align-items-center justify-content-center"
                data-toggle="tooltip" data-placement="left" title="Nová aukce">
                <span class="clickable material-icons text-white">add</span>
            </a>
        </div>
		<table class="table table-striped table-display-lg ">
			<thead>
				<tr>
					<th scope="col">Název</th>
					<th scope="col" class="text-center">Schválená</th>
					<th scope="col">Typ aukce</th>
					<th scope="col">Začátek aukce</th>
					<th scope="col" class="text-right">Počáteční cena</th>
					<th scope="col" class="text-right">Konečná cena</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
                <?php $imagePath = "storage/images/"; ?>
				@foreach ($auctions as $auction)
                        <?php $location = route('auctionDetail',  $auction->id); ?>
                        <tr onclick="window.location='{{$location}}'">
                            <td>{{$auction->auctionItem->item_name}}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @if($auction->is_approved)
                                        <span class="material-icons-outlined green-text md-36">check</span>
                                    @elseif(is_null($auction->is_approved))
                                        <span class="material-icons-outlined yellow-text md-36">watch_later</span>
                                    @else
                                        <span class="material-icons-outlined red-text md-36">clear</span>
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
                            @isset($actualPrices[$auction->id])
                                <td class="text-right">
                                        {{number_format($actualPrices[$auction->id] ,0 ,"", " ")}}	Kč
                                </td>
                            @else
                                <td class="text-right">-</td>
                            @endisset
                            <td class="text-right align-middle" style="padding-right:0">
                                <span class="clickable material-icons-outlined green-text md-24 pl-4 pr-3 text-right dont-propagate clickable" style="height: 24px;" onclick="openModal('{{ $auction->id }}',
                                        '{{ route('image.displayImage',$auction->auctionItem->image) }}', '{{ $auction->auctionItem->item_name }}', `{{ $auction->auctionItem->description }}`,
                                        '{{ $auction->starting_price }}', '{{ $auction->closing_price }}', '{{ $auction->is_approved }}', '{{ $auction->bid_min }}', '{{ $auction->bid_max }}', '{{ $auction->start_time }}', '{{ $auction->time_limit }}', '{{ $auction->is_open  }}', '{{ $auction->is_selling }}')"
                                        data-toggle="tooltip" data-placement="left" title="Upravit aukci">
                                        edit
                                </span>
                            </td>
                        </tr>
				@endforeach
				</tbody>
			</table>

			<table class="table table-striped table-display-sm" >
				<tbody>
					@foreach ($auctions as $auction)
                        <tr>
                            <?php $location = route('auctionDetail',  $auction->id); ?>
                            <td onclick="window.location='{{$location}}'">
                                <table class="table-plain" style="width:100%;">
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
                                            @elseif(is_null($auction->is_approved))
                                                <span class="material-icons-outlined yellow-text md-36">watch_later</span>
                                            @else
                                                <span class="material-icons-outlined red-text md-36">clear</span>
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
                                            @isset($actualPrices[$auction->id])
                                                <td>
                                                        {{number_format($actualPrices[$auction->id] ,0 ,"", " ")}}	Kč
                                                </td>
                                            @else
                                                <td>-</td>
                                            @endisset
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <button  type="button" class="btn dont-propagate btn-success" onclick="openModal('{{ $auction->id }}',
                                                '{{ route('image.displayImage',$auction->auctionItem->image) }}', '{{ $auction->auctionItem->item_name }}', `{{ $auction->auctionItem->description }}`,
                                                '{{ $auction->starting_price }}', '{{ $auction->closing_price }}', '{{ $auction->is_approved }}', '{{ $auction->bid_min }}', '{{ $auction->bid_max }}',
                                                '{{ $auction->start_time }}', '{{ $auction->time_limit }}', '{{ $auction->is_open  }}', '{{ $auction->is_selling }}')"
                                                    @if($auction->is_approved)
                                                        hidden
                                                    @endif
                                                    >
                                                    <div class="d-flex align-content-center">
                                                        <span class="clickable material-icons-outlined md-24 mr-3" style="height: 24px;" >edit</span>
                                                        Upravit aukci
                                                    </div>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
					@endforeach
			</tbody>
		</table>
	</div>
    @component('components/edit-auction')
    @endcomponent
@endsection
