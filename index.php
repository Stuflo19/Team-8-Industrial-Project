<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php 
  echo "Hello World"; 
?>

<head>
  <meta charset="utf-8">
  <!-- page title -->
  <title> Prototype | Home </title>

  <!-- import viewport properties -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- import bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- import css file -->
  <link rel="stylesheet" href="master.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>


<body>

  <header class="container-fluid p-1">

  </header>

  <!-- navigation bar with links -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav p-1 m-auto">
        <li class="nav-item">
          <a class="nav-link" href="">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="">Something</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="">Something else..</a>
        </li>
        

      </ul>
    </div>
  </nav>

  <main class="container-fluid p-5">

    <!-- Headings -->
    <div class="row">
      
      
    </div>

    <div class="row">
      <div class="col-lg">
        <div class="col-lg-7"> 
          <h3>Compliance Rules</h3>
        </div>
          <!-- Complaince Rule and Status -->
          <div class = "row mb-2"> 
            <div class="col-lg">
              <!-- Compliance Rule Card -->
              <div class="card cardColor text-center m-auto">
                <div class="card-body m-1 p-1">
                  <p class="card-text pb-1 m-auto"> Compliance Rule #1</p>
                  <div class="active-status">Compliant</div>
                </div>
                
                <button class="btn btn-outline-warning m-1" type="button" data-toggle="collapse" data-target="#detailsX" aria-expanded="false" aria-controls="collapseExample">
                  View details
                </button>
                <div class="collapse" id="detailsX">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                  </div>
                  <button type="button" class="btn btn-outline-warning float-right m-1">Add Exception</button>
                  <button type="button" class="btn btn-outline-warning float-right m-1">View Exception History</button>
                </div>
              </div>
            </div>
            
          </div>

          <!-- Complaince Rule and Status -->
          <div class = "row mb-2"> 
            <div class="col-lg">
              <!-- Compliance Rule Card -->
              <div class="card cardColor text-center m-auto">
                <div class="card-body m-1 p-1">
                  <p class="card-text pb-1 m-auto"> Compliance Rule #2</p>
                  <div class="exception-status"> Non-Compliant</div>
                </div>
                
                <button class="btn btn-outline-warning m-1" type="button" data-toggle="collapse" data-target="#detailsY" aria-expanded="false" aria-controls="collapseExample">
                  View details
                </button>
                <div class="collapse" id="detailsY">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                  </div>
                  <button type="button" class="btn btn-outline-warning float-right m-1">Add Exception</button>
                  <button type="button" class="btn btn-outline-warning float-right m-1">View Exception History</button>
                </div>
              </div>
            </div>
            
          </div>

          <!-- Complaince Rule and Status -->
          <!-- <div class = "row"> 
            <div class="col-lg">
              <div class="card cardColor text-center">
                <div class="card-body ">
                  <p class="card-text pb-1"> Compliance Rule #2</p>
                </div>
                <button class="btn btn-outline-warning m-1" type="button" data-toggle="collapse" data-target="#detailsY" aria-expanded="false">
                  View details
                </button>
                <div class="collapse" id="detailsY">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                  </div>
                  <button type="button" class="btn btn-outline-warning float-right m-1">Add Exception</button>
                  <button type="button" class="btn btn-outline-warning float-right m-1">View Exception History</button>
                </div>
              </div>
            </div>
            
          </div> -->

      </div>

      <!-- Placeholder for pie chart when we get it working -->
      <div class="col-lg-5" position="absolute">
        
        <h3>Overall Compliance</h3>
        
        <p> The objective is to get a pie chart display in here similar to the interface on our university attendance tracker "SEATs", which visualises a percentage of how many rules are compliant, those that have exceptions and those that are non-compliant</div>

    </div>

  </main>

  <!-- Footer -->
  <footer class="container-fluid page-footer footerDesign">
    <div class="row">
      <div class="col-lg-4">

        <!-- Store description -->
        <h6 class="mt-3">Footer Heading 1</h6>
        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sit amet leo nunc. Aliquam augue nulla, ullamcorper in fringilla eget, pulvinar id tellus. Vestibulum eros tortor, porttitor a tortor sit amet, consectetur auctor nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Ut lacinia sagittis sapien id cursus.</p>
      </div>

    </div>

    <div class="row">


      <div class="col font-italic text-justify mt-2">

        <p>This web app was developed by Stuart Florence, Neil McGuigan, Laura Naslenaite, Gregor Davis and Euan Storrie. </p>

      </div>

    </div>

  </footer>
  <!-- import bootstrap JS, Popper.js, and jQuery  -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="web-app/registerSW.js"></script>

</body>

</html>