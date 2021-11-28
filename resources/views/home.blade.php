@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex jumbotron justify-content-center flex-column bg-white">
            <h2>Online aukční portál pro věci všeho druhu.<br>Každá věc má u nás svou hodnotu!</h2>

            <div class="d-flex flex-md-nowrap flex-wrap justify-content-start flex-row">
                <a class="btn btn-success nav-link m-2 col-xs-2" href="{{ route('closestAuctions') }}" role="button">
                    <div class="d-flex justify-content-center">
                        Nejbližší aukce
                    </div>
                </a>
                <a class="btn btn-warning nav-link m-2 col-xs-2" href="{{ route('newAuction') }}" role="button">
                    <div class="d-flex justify-content-center">
                        Vytvořit aukci
                    </div>
                </a>
            </div>
        </div>
    </div>
	<div class="background-grey pt-2 pb-4">
        <div class="container">
                <div class="d-flex justify-content-center py-3">
                </div>
                <div>
                    <a href="{{ route('closestAuctions') }}" class="lists-links">
                        <div class="d-flex">
                            <h2 class="mr-1">Nejbližší aukce</h2>
                            <span class="material-icons md-36">navigate_next</span>
                        </div>
                    </a>
                    <div class="d-flex align-items-stretch mainPage-auction-list-container">
                            <div class = "align-items-center list-arrow-left hidesLeft">
                                    <div class="material-icons-outlined md-48" id="newAuctionLeft" onclick="leftScroll('#newAuctionList')">
                                            arrow_back_ios
                                    </div>
                            </div>
                            <div class="d-flex mainPage-auction-list align-items-stretch" id="newAuctionList">
                                @foreach ($auctions as $auction)
                                    <?php $route = route("auctionDetail", ["id" => $auction->id]) ?>
                                    <div class="mainPage-auction" onclick="window.location='{{$route}}'">
                                            <div class="img-container">
                                                @if ($auction->auctionItem->image)
                                                    <img src="{{ route('image.displayImage',$auction->auctionItem->image) }}" alt="Položka aukce"/>
                                                @else
                                                    <img src="{{ route('image.displayImage','empty.png') }}" alt="Položka aukce"/>
                                                @endif
                                            </div>
                                            <h4>{{ $auction->auctionItem->item_name }}</h4>

                                            @if ($auction->is_selling)
                                                <div class="mainPage-offer">
                                                    Nabídka
                                                </div>
                                            @else
                                                <div class="mainPage-buy">
                                                    Poptávka
                                                </div>
                                            @endif

                                            <h3>{{ $auction->is_open ? $auction->starting_price + $bids[$auction->id] : $auction->starting_price }} Kč</h3>
                                            <span>Začátek: {{ $auction->start_time }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class = "d-flex align-items-center list-arrow-right hidesRight">
                                    <div class="list-arrow" id="newAuctionRight" onclick="rightScroll('#newAuctionList')">
                                            <span class="material-icons-outlined md-48">arrow_forward_ios</span>
                                    </div>
                            </div>
                    </div>
            </div>
            <div class="mt-5">
                    <a href="{{ route('activeAuctions') }}" class="lists-links">
                        <div class="d-flex">
                            <h2 class="mr-1">Stihni přihodit</h2>
                            <span class="material-icons md-36">navigate_next</span>
                        </div>
                    </a>
                    <div class="d-flex align-items-stretch mainPage-auction-list-container">
                            <div class = "align-items-center list-arrow-left hidesLeft">
                                    <div class="material-icons-outlined md-48" id="newAuctionLeft" onclick="leftScroll('#favouriteAuctionList')">
                                            arrow_back_ios
                                    </div>
                            </div>
                            <div class="d-flex mainPage-auction-list align-items-stretch" id="favouriteAuctionList">
                            @foreach ($endSoon as $auction)
                                <?php $route = route("auctionDetail", ["id" => $auction->id]) ?>
                                <div class="mainPage-auction" onclick="window.location='{{$route}}'">
                                        <div class="img-container">
                                            @if ($auction->auctionItem->image)
                                                <img src="{{ route('image.displayImage',$auction->auctionItem->image) }}" alt="Položka aukce"/>
                                            @else
                                                <img src="{{ route('image.displayImage','empty.png') }}" alt="Položka aukce"/>
                                            @endif
                                        </div>
                                        <h4>{{ $auction->auctionItem->item_name }}</h4>

                                        @if ($auction->is_selling)
                                            <div class="mainPage-offer">
                                                Nabídka
                                            </div>
                                        @else
                                            <div class="mainPage-buy">
                                                Poptávka
                                            </div>
                                        @endif

                                        <h3>{{ $auction->is_open ? $auction->starting_price + $bids[$auction->id] : $auction->starting_price }} Kč</h3>
                                        <span>Konec: {{ $auction->time_limit }}</span>
                                </div>
                            @endforeach
                            </div>
                            <div class = "d-flex align-items-center list-arrow-right hidesRight">
                                    <div class="list-arrow" id="newAuctionRight" onclick="rightScroll('#favouriteAuctionList')">
                                            <span class="material-icons-outlined md-48">arrow_forward_ios</span>
                                    </div>
                            </div>
                    </div>
            </div>
        </div>
	</div>
@endsection
