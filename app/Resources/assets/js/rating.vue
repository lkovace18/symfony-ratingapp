<template>
  <div class="rating-box">
    <p class="title">{{ title }}</p>
    <p v-if="notification" class="notification is-info" v-text="notification"></p>
    <p v-if="error" class="notification is-danger" v-text="error"></p>
    <div class="star-rating">
      <fieldset>
        <div class="star" :class="{ 'star-active' : (i <= rating) }" v-for="i in 10">
          <input @click.prevent="vote(i)" type="radio" :id="i" name="rating" :value="i" />
          <label :for="i">{{ i }} stars</label>
        </div>
      </fieldset>
      <p>Page score {{ score }} / 10</p>
    </div>
  </div>
</template>
<script>

  export default {
    name: 'rating',
    mounted () {
      this.uri = window.location.href 
      this.getRating()
      let cookieVisitor = this.$cookie.get('rate-me-visitor');

      if(this.visitorId) {
        this.visitor = this.visitorId
        if( ! cookieVisitor ) {
          this.$cookie.delete('rate-me-visitor')
        }
      } else {
        if( ! cookieVisitor ) {
         this.visitor = this.generateVisitorId() 
       } else {
        this.visitor = cookieVisitor
      }

      this.$cookie.set('rate-me-visitor', this.visitor, 60)

      if (this.$cookie.get(this.visitor + this.uri)) {
        this.rated = true;
        this.rating = this.$cookie.get(this.visitor + this.uri);
      }

    }
  },
  data () {
    return {
      visitor: '',
      rating: 0,
      uri: '',
      score: 0,
      rated: false,
      notification: false,
      error: false,
    }
  },
  props: [
  'visitorId',
  'title',
  ],

  methods: {
    vote(rating) {
      this.notification = false
      this.error = false

      if(this.rated) {
        this.notification = 'Your vote is already submited, Tnx :)'
        return;
      }

      this.rated = true;
      this.rating = rating

      this.$cookie.set(this.visitor + this.uri, this.rating, 60)
      this.$http.post('http://iways.demo.dev/api/rating/vote',
      { 
        data: {
          visitor_id: this.visitor,
          rating: this.rating,
          uri: this.uri 
        }
      }
      ).then((response) => {
        this.score = response.data.data.score
        this.notification = 'Your vote is submited :)'
      }, (response) => {
        this.rated = false;
        this.error = 'Uphs, we have problem ... try again ?'
      })
    },
    getRating () {
      let data = {
        data: {
          uri: this.uri 
        }
      }
      this.$http.post('http://iways.demo.dev/api/rating', data)
      .then((response) => {
        this.score = response.data.data.score
      }, (response) => {
        this.error = 'Uphs, we have problem fetching data, try reload page'
      })
    },
    fourDigit() {
      return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
    },
    generateVisitorId() {
      return this.fourDigit() + this.fourDigit() + '-' + this.fourDigit() + '-' + this.fourDigit() + '-' + this.fourDigit() + '-' + this.fourDigit() + this.fourDigit() + this.fourDigit();
    }
  }
}
</script>

<style>
  .title {
    font-size: 2em;
  }
  .star {
    border: none;
    display: inline-block;
  }
  .star > input {
    position: absolute;
    clip: rect(0, 0, 0, 0);
  }
  .star > label {
    content: '\f006  ';
    float: right;
    width: 1em;
    padding: 0 .05em;
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    font-size: 200%;
    color: #4B77BE;
  }
  .star > label:before {
    position: relative;
    top: 2px;
    content: '\f006  ';
  }
  .star-active > input {
    position: absolute;
    clip: rect(0, 0, 0, 0);
  }
  .star-rating {
    font-family: 'FontAwesome';
    margin: 10px auto;
  }
  .star-rating > fieldset {
    border: none;
    display: inline-block;
  }
  .star-active > input {
    position: absolute;
    clip: rect(0, 0, 0, 0);
  }
  .star-active > label {
    float: right;
    width: 1em;
    padding: 0 .05em;
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    font-size: 200%;
    color: #4B77BE;
  }
  .star-active label:hover:before {
    position: relative;
    top: 2px;
    color: #5C97BF;
    content: '\f005';
  }
  .star-active label:before {
    position: relative;
    top: 2px;
    color: #5C97BF;
    content: '\f005';
  }
  .star-active {
    position: relative;
    top: 2px;
    color: #5C97BF;
    content: '\f005';
  }
  .rating-box {
    color: #95a5a6;
    font-family: 'Raleway';
    text-align: center;
  }
</style>
