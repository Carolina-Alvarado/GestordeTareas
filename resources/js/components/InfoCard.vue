<template>
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h3>{{ count }}</h3>
            <p class="mb-0">{{ title }}</p>
          </div>
          <i :class="`fa ${icon} fa-2x text-muted`"></i>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: ['icon', 'title', 'count']
  }
  </script>
