@extends('layouts.app')

@section('content')
    <div class="background-grey pt-5" style="margin-top:-30px;">
			<div class="container">
				<h1>Všechny aukce</h1>
				<div class="d-flex flex-wrap align-items-stretch  mainPage-auction-list">
					@foreach($auctions as $auction) 
						<div class="allAuctions-item">
							<div class="img-container d-flex align-items-center justify-content-center">
								<div> 
									<img class="img-fluid" src="{{ asset('storage/images/'.$auction->auctionItem->image) }}" alt="Položka aukce"/>
								</div>
							</div>
							<h4>{{ $auction->auctionItem->item_name}}</h4>
							@if ($auction->is_selling)
								<div class="mainPage-offer">
									Nabídka
								</div>
							@else
								<div class="mainPage-buy">
									Poptávka
								</div>
							@endif
							<h3>{{ $auction->starting_price }} Kč</h3>
							<span>Začátek: {{ $auction->start_time }}</span>
						</div>
					@endforeach
				</div>
			</div>
		</div>
@endsection