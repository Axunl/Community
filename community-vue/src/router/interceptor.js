//路由守卫
import common from '@/common/js/common'

export default function (to, from, next) {
  //console.log(to);
  if (to.meta.title) {
    document.title = to.meta.title
  }
  switch (to.path) {
    case '/publish':
    case '/profile':
    case '/question/edit/:id':
      if (!common.isLogin()) {
        return;
      }
      break;
  }
  next()
}
