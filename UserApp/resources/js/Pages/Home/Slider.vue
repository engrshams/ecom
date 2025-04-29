<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const props = defineProps({
    sliders: Array
});
</script>

<template>
  <Swiper
    :modules="[Navigation, Pagination, Autoplay]"
    :navigation="true"
    :pagination="{ clickable: true }"
    :loop="true"
    :autoplay="{ delay: 3000 }"
    :slides-per-view="2"   
    :space-between="20"    
    class="h-[300px]"
  >
    <SwiperSlide v-for="(slider, index) in sliders" :key="index">
      <img :src="slider.image" alt="Slider" class="w-full h-full object-cover" />
    </SwiperSlide>
  </Swiper>
</template>
