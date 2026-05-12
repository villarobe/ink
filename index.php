<?php
/**
 * index.php
 * Waves of Ink - Main Dashboard
 */
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Waves of Ink - Digital Library</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

</head>
<body>
<nav class="navbar-woi">
  <div class="container d-flex align-items-center justify-content-between">
    <div>
      <a class="navbar-brand-woi" href="#">Waves <span>of Ink</span></a>
      <div class="navbar-subtitle">Digital Library</div>
    </div>
    <div class="top-actions">
      <button class="btn-add-book btn-add-series" type="button" title="Add New Series" aria-label="Add New Series" data-bs-toggle="modal" data-bs-target="#seriesModal" onclick="openSeriesModal()">
        <svg class="btn-action-icon" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 5v14M5 12h14" />
        </svg>
      </button>
      <button class="btn-add-book" type="button" title="Add New Book" aria-label="Add New Book" data-bs-toggle="modal" data-bs-target="#addEditModal" onclick="openAddModal()">
        <svg class="btn-action-icon" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 5v14M5 12h14" />
        </svg>
      </button>
    </div>
  </div>
</nav>

<div class="container">
  <div class="page-header">
    <div class="page-header-copy">
      <h1>Welcome, Reader. Stay a While Between Stories.</h1>
      <p>A soft place for beloved worlds, favorite authors, and the next chapter waiting to be opened.</p>
    </div>
  </div>

  <div class="filter-bar">
    <button class="btn-filter active" data-filter="All">All</button>
    <button class="btn-filter" data-filter="Jonaxx">Jonaxx</button>
    <button class="btn-filter" data-filter="Inksteady">Inksteady</button>
    <button class="btn-filter" data-filter="Ongoing">Ongoing</button>
    <button class="btn-filter" data-filter="Completed">Completed</button>
  </div>

  <div id="bookGrid" class="library-groups mb-5"></div>

  <div id="emptyState" class="empty-state d-none">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
    </svg>
    <h3>No books found</h3>
    <p>Add your first book or change the filter.</p>
  </div>
</div>

<div class="modal fade" id="seriesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="seriesModalTitle">Add New Series</h5>
        <button type="button" class="btn-close-woi" data-bs-dismiss="modal">X</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editSeriesId" value="">

        <div class="mb-3">
          <label class="form-label-woi">Author <span style="color:#c0555a">*</span></label>
          <select id="seriesAuthor" class="form-select-woi">
            <option value="">Select Author</option>
            <option value="Jonaxx">Jonaxx</option>
            <option value="Inksteady">Inksteady</option>
          </select>
        </div>

        <div class="mb-1">
          <label class="form-label-woi">Series Name <span style="color:#c0555a">*</span></label>
          <input type="text" id="seriesName" class="form-control-woi" placeholder="e.g. King's &quot;Crown&quot; or Luna's Story" maxlength="255">
        </div>
        <small class="field-hint">Quotes like " and ' are supported in series names.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-woi-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn-woi-primary" id="saveSeriesBtn" onclick="saveSeries()">Save Series</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="seriesDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h5 class="modal-title" id="seriesDetailTitle">Series</h5>
          <div class="series-detail-subtitle" id="seriesDetailSubtitle"></div>
        </div>
        <button type="button" class="btn-close-woi" data-bs-dismiss="modal">X</button>
      </div>
      <div class="modal-body">
        <div id="seriesDetailBooks" class="series-detail-books"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-woi-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn-woi-primary" id="seriesDetailEditBtn">Edit Series</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addEditModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEditTitle">Add New Book</h5>
        <button type="button" class="btn-close-woi" data-bs-dismiss="modal">X</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editBookId" value="">

        <div class="mb-3">
          <label class="form-label-woi">Title <span style="color:#c0555a">*</span></label>
          <input type="text" id="bookTitle" class="form-control-woi" placeholder="e.g. The Bet" maxlength="255">
        </div>

        <div class="form-row mb-3">
          <div>
            <label class="form-label-woi">Author <span style="color:#c0555a">*</span></label>
            <select id="bookAuthor" class="form-select-woi">
              <option value="">Select Author</option>
              <option value="Jonaxx">Jonaxx</option>
              <option value="Inksteady">Inksteady</option>
            </select>
          </div>
          <div>
            <label class="form-label-woi">Book Series <span style="color:#c0555a">*</span></label>
            <select id="bookSeries" class="form-select-woi" disabled>
              <option value="">Select Author First</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label-woi">New Series <small style="font-weight:400;text-transform:none;color:var(--text-light)">(optional)</small></label>
          <input type="text" id="newSeriesName" class="form-control-woi" placeholder="Type a new series name if it does not exist yet" maxlength="255">
          <small class="field-hint">Entering a new series here will create it for the selected author and place this book inside it.</small>
        </div>

        <div class="mb-3">
          <label class="form-label-woi">Genre <span style="color:#c0555a">*</span></label>
          <input type="text" id="bookGenre" class="form-control-woi" placeholder="e.g. Romance / Drama" maxlength="100">
        </div>

        <div class="mb-3">
          <label class="form-label-woi">Description <span style="color:#c0555a">*</span></label>
          <textarea id="bookDescription" class="form-control-woi" rows="4" placeholder="Write a short summary of the book..."></textarea>
        </div>

        <div class="form-row mb-3">
          <div>
            <label class="form-label-woi">Status</label>
            <select id="bookStatus" class="form-select-woi">
              <option value="Ongoing">Ongoing</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
          <div>
            <label class="form-label-woi">Age Rating</label>
            <select id="bookRating" class="form-select-woi">
              <option value="13+">13+</option>
              <option value="16+">16+</option>
              <option value="18+">18+</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label-woi">Trigger Warnings <small style="font-weight:400;text-transform:none;color:var(--text-light)">(optional)</small></label>
          <textarea id="bookTrigger" class="form-control-woi" rows="2" placeholder="e.g. Contains themes of violence, mature language..."></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label-woi">Book Cover <small style="font-weight:400;text-transform:none;color:var(--text-light)">(JPG/PNG/WEBP, max 2 MB)</small></label>
          <input type="file" id="bookCover" class="form-control-woi" accept="image/jpeg,image/png,image/webp,image/gif" style="padding:7px 10px; cursor:pointer;">
          <div class="cover-preview" id="coverPreview">
            <img id="coverPreviewImg" src="" alt="Preview">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-woi-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn-woi-primary" id="saveBookBtn" onclick="saveBook()">Save Book</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Book Details</h5>
        <button type="button" class="btn-close-woi" data-bs-dismiss="modal">X</button>
      </div>
      <div class="modal-body" id="viewModalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn-woi-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn-woi-primary" id="viewEditBtn">Edit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content text-center">
      <div class="modal-body" style="padding:32px 24px">
        <div style="font-size:2.5rem; margin-bottom:12px;">Delete</div>
        <h5 style="font-family:'Playfair Display',serif; color:var(--brown-dark); margin-bottom:8px;">Delete Book?</h5>
        <p style="color:var(--text-light); font-size:.9rem;" id="deleteBookTitle">This cannot be undone.</p>
      </div>
      <div class="modal-footer justify-content-center" style="gap:12px">
        <button class="btn-woi-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn-woi-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
let allBooks = [];
let activeFilter = 'All';
let deleteTargetId = null;
let seriesByAuthor = {};
let activeSeriesDetail = null;

const seriesModal = new bootstrap.Modal(document.getElementById('seriesModal'));
const seriesDetailModal = new bootstrap.Modal(document.getElementById('seriesDetailModal'));
const addEditModal = new bootstrap.Modal(document.getElementById('addEditModal'));
const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

document.addEventListener('DOMContentLoaded', () => {
  loadBooks();
  initSeriesField();
  initFilter();
  initCoverPreview();
});

async function loadBooks() {
  try {
    const res = await fetch('process.php?action=list');
    const json = await res.json();
    if (json.success) {
      allBooks = json.data;
      renderGrid(allBooks);
    }
  } catch (e) {
    showToast('Failed to load books.', 'error');
  }
}

function renderGrid(books) {
  const filtered = books.filter(b => {
    if (activeFilter === 'All') return true;
    if (activeFilter === 'Jonaxx') return b.author === 'Jonaxx';
    if (activeFilter === 'Inksteady') return b.author === 'Inksteady';
    if (activeFilter === 'Ongoing') return b.status === 'Ongoing';
    if (activeFilter === 'Completed') return b.status === 'Completed';
    return true;
  });

  const grid = document.getElementById('bookGrid');
  const empty = document.getElementById('emptyState');

  if (!filtered.length) {
    grid.innerHTML = '';
    empty.classList.remove('d-none');
    return;
  }

  empty.classList.add('d-none');
  const grouped = groupBooks(filtered);
  grid.innerHTML = Object.entries(grouped).map(([author, seriesMap]) => authorSectionHTML(author, seriesMap)).join('');
}

function groupBooks(books) {
  return books.reduce((acc, book) => {
    const author = book.author || 'Unknown Author';
    const series = book.series_name || 'Standalone';

    if (!acc[author]) acc[author] = {};
    if (!acc[author][series]) acc[author][series] = [];

    acc[author][series].push(book);
    return acc;
  }, {});
}

function authorSectionHTML(author, seriesMap) {
  const totalBooks = Object.values(seriesMap).reduce((sum, books) => sum + books.length, 0);
  const totalSeries = Object.keys(seriesMap).length;

  return `
    <section class="author-section">
      <div class="author-section-header">
        <div>
          <div class="author-section-kicker">Author</div>
          <h2>${escHTML(author)}</h2>
        </div>
        <div class="author-section-stats">
          <span>${totalSeries} series</span>
          <span>${totalBooks} books</span>
        </div>
      </div>
      <div class="series-list">
        ${Object.entries(seriesMap).map(([seriesName, books]) => seriesSectionHTML(author, seriesName, books)).join('')}
      </div>
    </section>`;
}

function seriesSectionHTML(author, seriesName, books) {
  const seriesId = books[0]?.series_id || 0;
  return `
    <div class="series-card">
      <div class="series-card-header">
        <div>
          <div class="series-card-label">${escHTML(author)}</div>
          <div class="series-card-title-row">
            <button class="series-name-button" type="button" onclick="openSeriesDetail(${seriesId})">${escHTML(seriesName)}</button>
          </div>
        </div>
        <span class="series-card-count">${books.length} ${books.length === 1 ? 'book' : 'books'}</span>
      </div>
      <div class="series-books">
        ${books.map(bookCardHTML).join('')}
      </div>
    </div>`;
}

function bookCardHTML(book) {
  const coverHTML = book.book_cover
    ? `<img src="uploads/${escHTML(book.book_cover)}" class="book-card-cover" alt="${escHTML(book.title)}">`
    : `<div class="book-card-cover-placeholder"><span>${escHTML(book.title.charAt(0) || 'B')}</span></div>`;

  return `
    <article class="book-card" onclick="viewBook(${book.id})" title="${escHTML(book.title)}" aria-label="View ${escHTML(book.title)} details">
      <div class="book-card-media">
        ${coverHTML}
      </div>
    </article>`;
}

async function viewBook(id) {
  try {
    const res = await fetch(`process.php?action=get&id=${id}`);
    const json = await res.json();
    if (!json.success) {
      showToast('Could not load book details.', 'error');
      return;
    }

    const b = json.data;
    const coverHTML = b.book_cover
      ? `<img src="uploads/${escHTML(b.book_cover)}" style="width:100%;display:block;border-radius:8px;" alt="${escHTML(b.title)}">`
      : `<div class="placeholder-cover" style="aspect-ratio:3/4;display:flex;align-items:center;justify-content:center;padding:16px;">No Cover</div>`;

    const triggerSection = b.trigger_warning
      ? `<hr class="section-divider"><div class="view-label">Trigger Warnings</div><div class="trigger-warning-box"><strong>Content Notice</strong>${escHTML(b.trigger_warning)}</div>`
      : '';

    const seriesSection = b.series_name
      ? `<div class="view-label">Series</div><div class="view-value mb-3">${escHTML(b.series_name)}</div>`
      : '';

    document.getElementById('viewModalBody').innerHTML = `
      <div class="view-book-layout">
        <div class="view-book-cover">${coverHTML}</div>
        <div class="view-book-info">
          <h2>${escHTML(b.title)}</h2>
          <div style="color:var(--rose-deep);font-weight:700;font-size:.85rem;letter-spacing:.06em;text-transform:uppercase;margin-bottom:8px;">${escHTML(b.author)}</div>
          <div class="view-meta">
            <span class="badge-status ${b.status === 'Completed' ? 'badge-completed' : 'badge-ongoing'}">${escHTML(b.status)}</span>
            <span class="badge-rating">${escHTML(b.age_rating)}</span>
          </div>
          ${seriesSection}
          <div class="view-label">Genre</div>
          <div class="view-value mb-3">${escHTML(b.genre)}</div>
          <div class="view-label">Description</div>
          <div class="view-value">${escHTML(b.description)}</div>
          ${triggerSection}
        </div>
      </div>`;

    document.getElementById('viewEditBtn').onclick = () => {
      viewModal.hide();
      setTimeout(() => openEditModal(b.id), 350);
    };

    viewModal.show();
  } catch (e) {
    showToast('Error loading book.', 'error');
  }
}

function openAddModal() {
  document.getElementById('addEditTitle').textContent = 'Add New Book';
  clearForm();
}

function openSeriesModal(id = '', author = '', name = '') {
  document.getElementById('editSeriesId').value = id || '';
  document.getElementById('seriesAuthor').value = author || '';
  document.getElementById('seriesName').value = name || '';
  document.getElementById('seriesModalTitle').textContent = id ? 'Edit Series' : 'Add New Series';
}

async function saveSeries() {
  const id = document.getElementById('editSeriesId').value;
  const author = document.getElementById('seriesAuthor').value;
  const seriesName = document.getElementById('seriesName').value.trim();

  if (!author || !seriesName) {
    showToast('Please complete the series author and name.', 'error');
    return;
  }

  const btn = document.getElementById('saveSeriesBtn');
  btn.disabled = true;
  btn.textContent = 'Saving...';

  const fd = new FormData();
  fd.append('action', id ? 'series_edit' : 'series_add');
  if (id) fd.append('id', id);
  fd.append('author', author);
  fd.append('series_name', seriesName);

  try {
    const res = await fetch('process.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (!json.success) {
      showToast(json.message || 'Could not save series.', 'error');
      return;
    }

    seriesByAuthor = {};
    seriesModal.hide();
    document.getElementById('editSeriesId').value = '';
    document.getElementById('seriesAuthor').value = '';
    document.getElementById('seriesName').value = '';
    showToast(json.message, 'success');
    await loadBooks();

    if (activeSeriesDetail && String(activeSeriesDetail.id) === String(id || json.id || '')) {
      await openSeriesDetail(activeSeriesDetail.id);
    }
  } catch (e) {
    showToast('Network error while saving the series.', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Save Series';
  }
}

async function openSeriesDetail(seriesId) {
  if (!seriesId) return;

  try {
    const res = await fetch(`process.php?action=series_get&id=${encodeURIComponent(seriesId)}`);
    const json = await res.json();
    if (!json.success) {
      showToast(json.message || 'Could not load series.', 'error');
      return;
    }

    const series = json.data.series;
    const books = json.data.books || [];
    activeSeriesDetail = series;

    document.getElementById('seriesDetailTitle').textContent = series.series_name;
    document.getElementById('seriesDetailSubtitle').textContent = `${series.author} • ${books.length} ${books.length === 1 ? 'book' : 'books'}`;
    document.getElementById('seriesDetailBooks').innerHTML = books.length
      ? books.map(seriesDetailBookHTML).join('')
      : '<div class="series-detail-empty">No books in this series yet.</div>';

    document.getElementById('seriesDetailEditBtn').onclick = () => {
      seriesDetailModal.hide();
      setTimeout(() => {
        openSeriesModal(series.id, series.author, series.series_name);
        seriesModal.show();
      }, 250);
    };

    seriesDetailModal.show();
  } catch (e) {
    showToast('Failed to load series details.', 'error');
  }
}

function seriesDetailBookHTML(book) {
  return `
    <button type="button" class="series-detail-book-card" onclick="seriesDetailModal.hide(); setTimeout(() => viewBook(${book.id}), 250);">
      <span class="series-detail-book-card-title">${escHTML(book.title)}</span>
      <span class="series-detail-book-card-meta">${escHTML(book.genre)}</span>
      <span class="series-detail-book-card-badges">
        <span class="badge-status ${book.status === 'Completed' ? 'badge-completed' : 'badge-ongoing'}">${escHTML(book.status)}</span>
        <span class="badge-rating">${escHTML(book.age_rating)}</span>
      </span>
    </button>`;
}

async function openEditModal(id) {
  try {
    const res = await fetch(`process.php?action=get&id=${id}`);
    const json = await res.json();
    if (!json.success) {
      showToast('Could not load book.', 'error');
      return;
    }

    const b = json.data;
    document.getElementById('addEditTitle').textContent = 'Edit Book';
    document.getElementById('editBookId').value = b.id;
    document.getElementById('bookTitle').value = b.title;
    document.getElementById('bookAuthor').value = b.author;
    await syncSeriesOptions(b.author, b.series_id || '');
    document.getElementById('newSeriesName').value = '';
    document.getElementById('bookGenre').value = b.genre;
    document.getElementById('bookDescription').value = b.description;
    document.getElementById('bookStatus').value = b.status;
    document.getElementById('bookRating').value = b.age_rating;
    document.getElementById('bookTrigger').value = b.trigger_warning || '';
    document.getElementById('bookCover').value = '';

    if (b.book_cover) {
      document.getElementById('coverPreview').style.display = 'block';
      document.getElementById('coverPreviewImg').src = `uploads/${b.book_cover}`;
    } else {
      document.getElementById('coverPreview').style.display = 'none';
    }

    addEditModal.show();
  } catch (e) {
    showToast('Failed to load book data.', 'error');
  }
}

async function saveBook() {
  const id = document.getElementById('editBookId').value;
  const title = document.getElementById('bookTitle').value.trim();
  const author = document.getElementById('bookAuthor').value;
  const seriesId = document.getElementById('bookSeries').value;
  const newSeries = document.getElementById('newSeriesName').value.trim();
  const genre = document.getElementById('bookGenre').value.trim();
  const description = document.getElementById('bookDescription').value.trim();
  const status = document.getElementById('bookStatus').value;
  const ageRating = document.getElementById('bookRating').value;
  const trigger = document.getElementById('bookTrigger').value.trim();
  const coverFile = document.getElementById('bookCover').files[0];

  if (!title || !author || !genre || !description || (!seriesId && !newSeries)) {
    showToast('Please complete the required fields, including the book series.', 'error');
    return;
  }

  const btn = document.getElementById('saveBookBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-woi"></span>Saving...';

  const fd = new FormData();
  fd.append('action', id ? 'edit' : 'add');
  if (id) fd.append('id', id);
  fd.append('title', title);
  fd.append('author', author);
  fd.append('series_id', seriesId);
  fd.append('new_series_name', newSeries);
  fd.append('genre', genre);
  fd.append('description', description);
  fd.append('status', status);
  fd.append('age_rating', ageRating);
  fd.append('trigger_warning', trigger);
  if (coverFile) fd.append('book_cover', coverFile);

  try {
    const res = await fetch('process.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.success) {
      showToast(json.message, 'success');
      if (author) {
        delete seriesByAuthor[author];
      }
      addEditModal.hide();
      clearForm();
      loadBooks();
    } else {
      showToast(json.message || 'An error occurred.', 'error');
    }
  } catch (e) {
    showToast('Network error. Please try again.', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Save Book';
  }
}

function promptDelete(id, title) {
  deleteTargetId = id;
  document.getElementById('deleteBookTitle').textContent = `"${title}" will be permanently removed.`;
  deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
  if (!deleteTargetId) return;

  const btn = document.getElementById('confirmDeleteBtn');
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', deleteTargetId);

    const res = await fetch('process.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.success) {
      showToast('Book deleted.', 'success');
      deleteModal.hide();
      loadBooks();
    } else {
      showToast(json.message || 'Delete failed.', 'error');
    }
  } catch (e) {
    showToast('Network error.', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Delete';
    deleteTargetId = null;
  }
});

function initFilter() {
  document.querySelectorAll('.btn-filter').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeFilter = btn.dataset.filter;
      renderGrid(allBooks);
    });
  });
}

function initSeriesField() {
  document.getElementById('bookAuthor').addEventListener('change', async function () {
    document.getElementById('newSeriesName').value = '';
    await syncSeriesOptions(this.value);
  });
}

async function syncSeriesOptions(author, selectedSeriesId = '') {
  const seriesSelect = document.getElementById('bookSeries');

  if (!author) {
    seriesSelect.innerHTML = '<option value="">Select Author First</option>';
    seriesSelect.disabled = true;
    return;
  }

  try {
    const res = await fetch(`process.php?action=series_list&author=${encodeURIComponent(author)}`);
    const json = await res.json();

    if (!json.success) {
      showToast(json.message || 'Could not load series.', 'error');
      return;
    }

    seriesByAuthor[author] = json.data;
    seriesSelect.disabled = false;
    seriesSelect.innerHTML = '<option value="">Select Series</option>' + json.data.map(series => `<option value="${escHTML(series.id)}">${escHTML(series.series_name)}</option>`).join('');

    if (selectedSeriesId) {
      seriesSelect.value = String(selectedSeriesId);
    }
  } catch (e) {
    showToast('Failed to load book series.', 'error');
  }
}

function initCoverPreview() {
  document.getElementById('bookCover').addEventListener('change', function () {
    const file = this.files[0];
    const preview = document.getElementById('coverPreview');
    const img = document.getElementById('coverPreviewImg');

    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        img.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      preview.style.display = 'none';
    }
  });
}

function clearForm() {
  ['bookTitle', 'newSeriesName', 'bookGenre', 'bookDescription', 'bookTrigger'].forEach(id => {
    document.getElementById(id).value = '';
  });
  document.getElementById('bookAuthor').value = '';
  document.getElementById('bookSeries').innerHTML = '<option value="">Select Author First</option>';
  document.getElementById('bookSeries').disabled = true;
  document.getElementById('bookStatus').value = 'Ongoing';
  document.getElementById('bookRating').value = '13+';
  document.getElementById('bookCover').value = '';
  document.getElementById('editBookId').value = '';
  document.getElementById('coverPreview').style.display = 'none';
}

function showToast(message, type = 'success') {
  const container = document.getElementById('toastContainer');
  const toast = document.createElement('div');
  toast.className = `woi-toast ${type}`;
  toast.textContent = `${type === 'success' ? 'Success: ' : 'Warning: '}${message}`;
  container.appendChild(toast);
  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity .3s';
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

function escHTML(str) {
  return String(str ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

function escJS(str) {
  return String(str ?? '').replace(/'/g, "\\'").replace(/</g, '\\x3C');
}
</script>
</body>
</html>
