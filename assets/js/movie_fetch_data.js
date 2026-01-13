document.addEventListener('turbo:load', () => {

  const suggestions = document.querySelector('#movie-suggestions');

  const input = document.querySelector('input[name="event_form[event_movie]"]');
  const movie_year = document.querySelector('input[name="event_form[event_movie_year]"]');
  const movie_picture = document.querySelector('input[name="event_form[event_movie_picture]"]');
  const movie_detail_input = document.querySelector('textarea[name="event_form[event_detail]"]');
  const movie_picture_display = document.getElementById('movie_poster');
  const movie_genre = document.querySelector('textarea[name="event_form[event_movie_genre]"]');

  if (!input || !suggestions){
    return;
  } 
  
  let Timer
  input.addEventListener('input', () => {
    const query = input.value.trim();
    clearTimeout(Timer);
    if (query.length < 3) {
      suggestions.classList.add('hidden');
      return;
    }
    Timer = setTimeout(() => fetchMovies(query), 300);
  });

  async function fetchMovies(query) {
    const res = await fetch(`/api/tmdb/search?q=${encodeURIComponent(query)}`);
    const data = await res.json();
    displaySuggestions(data.results);
  }

  function displaySuggestions(results) {
    if (!results.length) {
      return suggestions.classList.add('hidden');
    }      

    suggestions.innerHTML = results.slice(0, 5).map(movie => `
      <li class="p-2 hover:bg-accent cursor-pointer" data-title="${movie.title}" data-release_date="${movie.release_date}" data-overview="${movie.overview}" data-poster_path="${movie.poster_path}" data-genre="${movie.genre_ids}">
       ${movie.title} <span class="text-gray-500 text-m">(${movie.release_date?.slice(0,4) || 'N/A'})</span>
      </li>`).join('');
    suggestions.classList.remove('hidden');

    suggestions.querySelectorAll('li').forEach(li => {
      li.addEventListener('click', () => {
        populateForm(li.dataset);
        suggestions.classList.add('hidden');
      });
    });
  }

  function populateForm(dataset) {
    input.value = dataset.title;
    movie_detail_input.value = dataset.overview;
    movie_year.value = dataset.release_date;
    movie_genre.value = dataset.genre;
    movie_picture.value = `https://image.tmdb.org/t/p/w500${dataset.poster_path}`;
    movie_picture_display.src = `https://image.tmdb.org/t/p/w500${dataset.poster_path}`;
  }
});