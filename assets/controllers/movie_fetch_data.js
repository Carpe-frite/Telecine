document.addEventListener('turbo:load', () => {
  const input = document.querySelector('input[name="event_form[event_movie]"]');
  const suggestions = document.querySelector('#movie-suggestions');

  const movie_year = document.querySelector('input[name="event_form[event_movie_year]"]');

  if (!input || !suggestions) return;
  
  let debounceTimer;
  input.addEventListener('input', () => {
    const query = input.value.trim();
    clearTimeout(debounceTimer);
    if (query.length < 2) {
      suggestions.classList.add('hidden');
      return;
    }
    debounceTimer = setTimeout(() => fetchMovies(query), 300);
  });

  async function fetchMovies(query) {
    const res = await fetch(`/api/tmdb/search?q=${encodeURIComponent(query)}`);
    const data = await res.json();
    renderSuggestions(data.results);
  }

  function renderSuggestions(results) {
    if (!results.length) return suggestions.classList.add('hidden');

    suggestions.innerHTML = results.slice(0, 5).map(movie => `
      <li class="p-2 hover:bg-gray-100 cursor-pointer" data-title="${movie.title}" data-release_date="${movie.release_date}">
        ${movie.title} <span class="text-gray-400 text-sm">(${movie.release_date?.slice(0,4) || 'N/A'})</span>
      </li>
    `).join('');
    suggestions.classList.remove('hidden');

    suggestions.querySelectorAll('li').forEach(li => {
      li.addEventListener('click', () => {
        input.value = li.dataset.title;
        movie_year.value = li.dataset.release_date || '1900-01-01';
        suggestions.classList.add('hidden');
      });
    });
  }
});