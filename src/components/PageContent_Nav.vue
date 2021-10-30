<template>
  <div class="sub-nav-items col d-lg-flex align-items-end px-0 mb-3 bg-white shadow-sm">

    <div :style="{ minHeight:'0px'}" class="col p-0 d-flex flex-wrap mr-md-2">
      <slot name="menu"></slot>
    </div>

    <div class="d-flex flex-wrap justify-content-end align-items-top">
      <slot name="btn"></slot>
    </div>

  </div>
</template>