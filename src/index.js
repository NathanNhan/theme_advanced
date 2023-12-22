import "../css/style.scss"
// Our modules / classes
import MobileMenu from "./modules/MobileMenu"
import HeroSlider from "./modules/HeroSlider"
import Search from "./modules/Search"
import Like from "./modules/Like"
import MyNotes from "./modules/MyNotes"
// Instantiate a new object using our modules/classes
const mobileMenu = new MobileMenu()
const heroSlider = new HeroSlider()

const liveSearch = new Search();

const likeBox = new Like();

const mynotes = new MyNotes();