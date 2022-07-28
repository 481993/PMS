@include ('frontend.includes.footer-comment-area')

<footer class="footer section pb-1 overflow-hidden">
    <div class="container">
        <div class="row">
            <div class="col pb-4 mb-md-0">
                <div class="d-flex text-center justify-content-center align-items-center">
                    <p class="font-weight-normal mb-0 account-name">
                        <!-- &copy; {{ app_name() }}, {!! setting('footer_text') !!} -->
                        &copy; {!! setting('footer_text') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
