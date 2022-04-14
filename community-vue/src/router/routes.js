//路由映射
const List = () => import('@/views/List')
const Question = () => import('@/views/Question')
const Publish = () => import('@/views/Publish')
const Profile = () => import('@/views/profile/Profile')
const Questions = () => import('@/views/profile/Questions')
const Replies = () => import('@/views/profile/Replies')
const Edit = () => import('@/views/Edit')
export default [
  {
    path: '/',
    redirect: 'list',
    meta: {
      title: '学习交流社区'
    }
  },
  {
    path: '/list',
    component: List,
    meta: {
      title: '列表'
    }
  },
  {
    path: '/question/:id',
    component: Question
  },
  {
    path: '/publish',
    component: Publish,
    meta: {
      title: '提问'
    }
  },
  {
    path: '/profile',
    component: Profile,
    children: [
      {
        path: 'questions',
        component: Questions,
        meta: {
          title: '我的问题'
        }
      },
      {
        path: 'replies',
        component: Replies,
        meta: {
          title: '最新回复'
        }
      }
    ]
  },
  {
    path: '/question/edit/:id',
    component: Edit
  },
]
