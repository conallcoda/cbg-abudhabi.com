<template>
  <div class="k-block-hero" @dblclick="open">
    <div class="k-block-hero--image">
      <k-cropped-image preset="landscape" :image="image" @open="open" />
    </div>
    <div class="k-block-hero--content">
      <div class="k-block-hero--title">
        <k-writer
          ref="title"
          :inline="titleField.inline"
          :marks="titleField.marks"
          :placeholder="defaultTitle"
          :value="this.content.title"
          @input="update({ title: $event })"
        />
      </div>
      <div class="k-block-hero--subtitle">
        <k-writer
          ref="subtitle"
          :inline="subtitleField.inline"
          :marks="subtitleField.marks"
          :placeholder="subtitleField.placeholder"
          :value="content.subtitle"
          @input="update({ subtitle: $event })"
        />
      </div>
      <k-buttons
        :align="content.align"
        :buttons="content.buttons"
        @open="open"
      />
    </div>
  </div>
</template>

<script>
/**
 * @displayName BlockTypeHero
 * @internal
 */
export default {
  data() {
    return {
      defaultTitle: null,
      defaultImage: null,
    };
  },
  mounted() {
    const model = this.$store.getters["content/model"]();
    const path = model.api.replace("/pages/", "").replace("+", "/");
    this.$api.get("page-data/" + path).then((data) => {
      
      if (data.site.hero_image) {
        this.defaultImage = data.site.hero_image.presets.landscape;
      }
      this.defaultTitle = data.page.title;
    });
  },
  computed: {
    image() {
      return this.content.images.length
        ? this.content.images[0]
        : this.defaultImage;
    },
    titleField() {
      return this.field("title");
    },
    subtitleField() {
      return this.field("subtitle");
    },
  },
};
</script>


<style>
.k-block-hero {
  position: relative;
}
.k-block-hero--content {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 10;
  display: flex;
  justify-content: center;
  align-items: center;
  display: flex;
  flex-direction: column;
}

.k-block-hero--title p,
.k-block-hero--subtitle p {
  text-shadow: 1px 1px 1px #000000;
}

.k-block-hero--title {
  font-family: var(--titleFont);
  color: white;
  font-weight: var(--font-bold);
  font-size: 6rem;
  border-top: 4px solid white;
  border-bottom: 4px solid white;
  text-transform: uppercase;
}

.k-block-hero--title .k-writer[data-placeholder][data-empty]:before,
.k-block-hero--subtitle .k-writer[data-placeholder][data-empty]:before {
  color: white;
}
 {
  color: white;
}

.k-block-hero--subtitle {
  margin: 2rem 0;
  font-family: var(--titleFont);
  color: white;
  font-weight: var(--font-bold);
  font-size: var(--text-2xl);
}
</style>