<template>
  <section id="video">
    <div class="flex flex-col py-2 md:flex-row md:justify-between md:items-center">
      <div class="font-serif text-lg">
        Video &amp; Webinar Archive
      </div>
      <div class="w-full my-2 search-filter md:w-1/2 lg:w-1/4">
        <div class="relative w-full">
          <input type="text" class="w-full h-10 p-2 pr-12 border rounded-none border-smoke-300 focus:border-verdigris-500 focus:outline-none" name="searchQuery" placeholder="Search by keyword or phrase" v-model="searchfilter" />
          <span class="absolute top-0 right-0 flex items-center justify-center w-10 h-10 px-4 text-verdigris-500 flex-column">
            <i class="my-auto fa fa-search"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="divider"></div>
    <paginate name="paged" :list="filteredposts" :per="8" :key="searchfilter">
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
        <div v-for="post in paginated('paged')" :key="post.id">
          <a class="thumb" :href="post.link" :alt="post.title">
            <div class="thumb-border">
              <vue-aspect-ratio ar="16:9">
                <img :src="post.img" alt="" class="object-cover w-full h-full" />
                <!-- <div class="flex items-center justify-center video-icon">
                  <i class="fa fa-play-circle"></i>
                </div> -->
              </vue-aspect-ratio>
            </div>
            <div class="my-4 video-title" :href="post.link" v-html="post.title"></div>
          </a>
        </div>
      </div>
    </paginate>
    <div class="py-8">
      <paginate-links class="flex flex-row justify-center" v-show="filteredposts.length > 8" for="paged" :show-step-links="true" :step-links="{next: 'Next', prev: 'Previous'}"></paginate-links>
    </div>
  </section>
</template>

<script>
export default {
    name: 'App',

    components: {},

    data: () => ({
        width: null,
        allposts: [],
        showposts: [],
        searchfilter: undefined,
        paginate: ['paged'],
    }),
    created() {
        async function getPosts() {
            const response = await fetch('/wp-json/custom/resources')
            let posts = await response.json()
            return posts.filter((post) => post.type === 'videos')
        }
        getPosts().then((data) => {
            data = data.sort(function (a, b) {
                return new Date(b.date) - new Date(a.date)
            })
            this.allposts = data
        })
    },
    methods: {
        more() {
            this.numberposts += 9
        },
        less() {
            this.numberposts -= 9
        },
        resetPage() {
            this.page = 1
        },
    },
    computed: {
        filteredposts() {
            if (!this.searchfilter) {
                return this.allposts
            }
            return this.allposts.filter((post) => {
                if (!this.searchfilter) {
                    return true
                }
                if (
                    post.title
                        .toLowerCase()
                        .includes(this.searchfilter.toLowerCase()) ||
                    post.excerpt
                        .toLowerCase()
                        .includes(this.searchfilter.toLowerCase())
                )
                    return true
            })
        },
        posttitles() {
            let titles = []
            titles = this.filteredposts.map((post) => post.title)
            return titles
        },
    },
}
</script>
<style lang="scss">
#video {
    @import './assets/main.scss';
    .border-verdigris-500 {
        border-color: #23b3ae;
    }
    .text-verdigris-500 {
        color: #23b3ae;
    }
    ul {
        list-style: none;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .paginate-links {
        li {
            a {
                user-select: none;
                display: inline-block;
                margin-right: 0.5rem;
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
                padding-left: 1rem;
                padding-right: 1rem;
                border-width: 1px;
                border-color: #e2e8f0;
                cursor: pointer;
                text-align: center;
                &:hover {
                    background-color: #23b3ae;
                    border-color: #23b3ae;
                    color: #ffffff;
                }
            }
        }
        .right-arrow a,
        .left-arrow a {
            min-width: 8rem;
        }
        .disabled a {
            // display: none;
            color: #dad9d8;
            &:hover {
                color: #dad9d8;
                background-color: transparent;
                border-color: #e2e8f0;
            }
        }
        .active a {
            background-color: #dad9d8;
            color: #4a4a4a;
        }
        @media (max-width: 600px) {
            .number:not(.active) {
                display: none;
            }
        }
    }
    .thumb {
        text-decoration: none;
    }
    .thumb-border {
        position: relative;
    }
    .thumb-border .v-image {
        border: 1px solid #f1f1f1;
    }
    .thumb-border .video-icon {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000000;
        opacity: 0.25;
        font-size: 3rem;
        color: #fff;
    }
    .video-title {
        color: #4a4a4a;
        font-size: 14px;
        font-weight: 400;
    }
    .divider {
        border-bottom: 1px solid #ecb558;
        margin: 0 auto 1rem;
    }
    .title,
    .search-filter {
        padding-bottom: 4px;
    }
}
</style>
