import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from "./routes";
import interceptor from "./interceptor";

Vue.use(VueRouter)
const routerPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return routerPush.call(this, location).catch(error => error)
}

const router = new VueRouter({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes
})
router.beforeResolve(interceptor);
export default router
