<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog rounded modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-body">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <form method="POST" files="true" enctype="multipart/form-data">
                <input type="text" name="id" id="id" class="d-none">
                <div class="mt-4 mb-5">
                    <h5 class="modal-title" id="exampleModalLabel">Upravit</h5>
                        @csrf
                        <div class="d-lg-flex align-items-center flex-lg-row my-1 mb-5">
                            <div class="col">
                                <div class="d-flex justify-content-center align-items-end p-2">
                                    <img id="previewImg" src="../../img/empty.png" class="previewImg img-fluid"/>
                                    <label for="image" class="addImgBtn">
                                        <span class="material-icons-outlined md-36">add</span>
                                    </label>
                                    <input class="d-none" type="file" accept="image/*" name="image" id="image" onchange="showPreview(this)">
                                </div>
                            </div>
                            <div class="col">
                                <label for="name">Název</label>
                                <input type="text" class="form-control" id="edit-name" name="name" required>
                                <label for="name">Popis</label>
                                <textarea class="form-control" id="edit-description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="d-lg-flex  flex-lg-row my-1">
                            <div class="col">
                                <label for="startPrice">Počáteční cena</label>
                                <input type="number" class="form-control startPrice" id="edit-startPrice" name="startPrice" required >
                                <div id="startPriceError" class="invalid-feedback"></div>
                            </div>
                            <div class="col">
                                <label for="endPrice">Konečná cena</label>
                                <input type="number" class="form-control closingPrice" id="edit-endPrice" name="endPrice" required >
                                <div id="closingPriceError"  class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="d-lg-flex  flex-lg-row my-1 mb-5">
                            <div class="col bidRange">
                                <label for="bidRange">Rozsah příhozů</label>
                                <div class="d-flex bid-range" id="bidRange">
                                    <input type="number" class="form-control mr-1 bid_min" id="edit-startRange" name="min_bid" required>
                                    <input type="number" class="form-control ml-1 bid_max" id="edit-endRange" name="max_bid" required>
                                </div>
                                <div id="bidError" class="invalid-feedback"></div>
                            </div>
                            <div class="col"></div>
                        </div>

                        <div class="d-lg-flex  flex-lg-row mb-5">
                            <div class="col">
                                <label for="auctionStart">Začátek aukce</label>
                                <input type="datetime-local" class="form-control auctionStart" id="edit-auctionStart" name="auctionStart" required />
                                <div id="auctionStartError" class="invalid-feedback"></div>
                            </div>
                            <div class="col">
                                <label for="auctionEnd">Konec aukce</label>
                                <input type="datetime-local" class="form-control auctionEnd" id="edit-auctionEnd" name="auctionEnd" required/>
                                <div id="auctionEndError" class="invalid-feedback"></div>
                            </div>
                        </div>

                        <script>
                            function getToday(){
                                var date = new Date();
                                date.setHours( date.getHours() + 1 );
                                var dateTime = date.toISOString().slice(0, 16);
                                return dateTime;
                            }

                            $(document).ready(function (){
                                $("#auctionStart").val(getToday());
                                $("#auctionStart").attr("min", getToday());
                                $("#auctionEnd").val(getToday());
                                $("#auctionEnd").attr("min", getToday());
                            })
                        </script>

                        <div class="d-md-flex  flex-lg-row mb-5">
                            <div class="col">
                                <label for="type">Typ aukce</label>
                                <div class="d-flex choose-from-2" id="type">
                                    <div class="col chooseBtn label-green text-center chooseBtn-not-checked" id="btnbuy" onclick="chooseFromClicked('#btnbuy', '#btnsell')">
                                        Nákup
                                        <input type="radio" name="is_selling" id="buy" class="d-none" value="0" />
                                    </div>
                                    <div class="col chooseBtn label-yellow text-center" id="btnsell" onclick="chooseFromClicked('#btnsell', '#btnbuy')">
                                        Prodej
                                        <input type="radio" checked="checked" name="is_selling" id="sell" class="d-none" value="1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="rules">Pravidla aukce</label>
                                <div class="d-flex choose-from-2" id="rules">
                                    <div class="col chooseBtn label-green text-center " id="btnopen" onclick="chooseFromClicked('#btnopen', '#btnclosed')">
                                        Otevřená
                                        <input type="radio" checked="checked" name="is_open" id="open" class="d-none" value="1" />
                                    </div>
                                    <div class="col chooseBtn label-yellow text-center chooseBtn-not-checked" id="btnclosed" onclick="chooseFromClicked('#btnclosed', '#btnopen')">
                                        Uzavřená
                                        <input type="radio" name="is_open" id="closed" class="d-none closed" value="0" />
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col d-flex justify-content-end align-items-end">
                    <div class="flex-1">
                        <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">Zrušit</button>
                        <button type="submit" class="btn btn-success inv_after_approved m-1" id="submitAuction">Uložit změny</button>
                    </div>
                    @if(Route::currentRouteName() == 'userAuctions' || Auth::user()->is_admin())
                        <button type="button" id="deleteButton" name="deleteItem" value="true" class="btn btn-danger inv_after_approved m-1" style="height: 40px;" data-target="{{ url()->current() }}">Smazat</button>
                    @endif
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
