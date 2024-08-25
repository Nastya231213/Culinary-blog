     <div class="info-site">
         <img src="{{ asset('images/info-image.webp') }}" alt="Cover image">
         <p>Hello! I cook fresh, interesting recipes. My cat Cookie catches the crumbs.</p>
         <ul>
             <li><a href="#">Contact</a></li>
             <li><a href="#">New Here?</a></li>
             <li><a href="#">All categories</a></li>
         </ul>
     </div>
     <div class="popular-items">
         <h4>Popular Recipes</h4>
         @foreach($popularRecipes as $recipe)
         <div class="row mt-1">
             <div class="col-md-4">
                 <img src="{{ asset('storage/post_photos/'.$recipe->main_photo_url) }}" alt="Post image">
             </div>
             <div class="col-md-8">
                 <p>{{ $recipe->title }}</p>
             </div>
         </div>
         @endforeach

     </div>
     <div class="popular-items">
         <h4>Popular Categories</h4>

         @foreach($popularCategories as $category)
         <div class="row mt-1">
             <div class="col-md-4">
                 <img src="{{ asset('storage/category_photos/'.$category->image )}}" alt="Category image">

             </div>
             <div class="col-md-8">
                 <p>{{ $category->name }}</p>
             </div>
         </div>
         @endforeach

     </div>
     <div class="mt-2">
         <a href="{{route('categories.index')}}" id="more-favourites-link">More categories >></a>
     </div>