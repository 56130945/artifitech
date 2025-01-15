<!-- News Modal -->
<div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <img id="modalNewsImage" src="" alt="News Image" class="img-fluid rounded mb-4 w-100" style="max-height: 400px; object-fit: cover;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="date text-primary me-3">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    <span id="modalNewsDate"></span>
                                </div>
                                <div class="category bg-primary text-white px-3 py-1 rounded">
                                    <span id="modalNewsCategory"></span>
                                </div>
                            </div>
                            <h2 id="modalNewsTitle" class="mb-4"></h2>
                            <div id="modalNewsContent" class="news-content"></div>
                            
                            <!-- Social Share Buttons -->
                            <div class="mt-4 pt-3 border-top">
                                <h5 class="mb-3">Share this article</h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary" onclick="shareNews('twitter')">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button class="btn btn-primary" onclick="shareNews('facebook')">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                    <button class="btn btn-primary" onclick="shareNews('linkedin')">
                                        <i class="fab fa-linkedin-in"></i>
                                    </button>
                                    <button class="btn btn-primary" onclick="shareNews('whatsapp')">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Related Articles -->
                            <div class="mt-5">
                                <h4 class="mb-4">Related Articles</h4>
                                <div class="row g-4" id="relatedArticles"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
