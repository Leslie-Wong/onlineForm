<template>
    <notifications
      group="success"
      :duration="5000"
      :width="500"
      animation-name="v-fade-right"
      position="bottom right"
      dangerously-set-inner-html
    >
      <template #body="props">
        <div class="custom-template success">
          <div class="custom-template-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="custom-template-content">
            <div class="custom-template-title">
              {{ props.item.title }}
            </div>
            <div
              class="custom-template-text"
              v-html="props.item.text"
            />
          </div>
          <div
            class="custom-template-close"
            @click="props.close"
          >
            <i class="fas fa-times-circle"></i>
          </div>
        </div>
      </template>
    </notifications>

    <notifications
      group="error"
      :duration="5000"
      :width="500"
      animation-name="v-fade-right"
      position="bottom right"
      dangerously-set-inner-html
    >
      <template #body="props">
        <div class="custom-template error">
          <div class="custom-template-icon">
            <i class="fas fa-exclamation-circle"></i>
          </div>
          <div class="custom-template-content">
            <div class="custom-template-title">
              {{ props.item.title }}
            </div>
            <div
              class="custom-template-text"
              v-html="props.item.text"
            />
          </div>
          <div
            class="custom-template-close"
            @click="props.close"
          >
            <i class="fas fa-times-circle"></i>
          </div>
        </div>
      </template>
    </notifications>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    name: "JigNotifications",
    methods: {
        close(group) {
            this.$notify({ group, clean: true });
        }
    }
});
</script>

<style lang="scss">
.custom-template.error {
    .custom-template-icon {
        flex: 0 1 auto;
        color: #ff815a;
        font-size: 32px;
        padding: 0 10px;
    }
}

.custom-template {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;

    text-align: left;
    font-size: 13px;
    margin: 5px;
    margin-bottom: 0;
    align-items: center;
    justify-content: center;

    &, & > div {
      box-sizing: border-box;
    }

    background: #E8F9F0;
    border: 2px solid #D0F2E1;


    .custom-template-icon {
      flex: 0 1 auto;
      color: #15C371;
      font-size: 32px;
      padding: 0 10px;
    }

    .custom-template-close {
      flex: 0 1 auto;
      padding: 0 20px;
      font-size: 16px;
      opacity: 0.2;
      cursor: pointer;

      &:hover {
        opacity: 0.8;
      }
    }

    .custom-template-content {
      padding: 10px;
      flex: 1 0 auto;

      .custom-template-title {
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 10px;
      }
    }
  }
</style>
